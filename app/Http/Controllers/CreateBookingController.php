<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\UserActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RedeemPeacePoint\RedeemPeacePointCommitRequest;
use App\Http\Requests\RedeemPeacePoint\RedeemPeacePointViewRequest;
use App\Http\Requests\Soap\Booking\CreateBookingRequest;
use App\Services\Payment\Payments;
use App\Services\Utility\CheckArray;
use App\Services\Utility\GetPointService;
use App\Services\Soap\CreateBookingBuilder;
use App\Services\Wallet\VerificationService;
use App\Services\Wallet\FlutterVerificationService;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Services\TicketReservations\TicketReservation;
use Exception;

class CreateBookingController extends Controller
{
    protected $createBookingBuilder;
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $checkArray;
    protected $ticketReservationRequestBuilder;
    protected $getPointService;
    protected $payments;
    protected $ticketReservationService;

    public function __construct( Payments $payments, TicketReservation $ticketReservationService, CreateBookingBuilder $createBookingBuilder, TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray, GetPointService $getPointService) {
        $this->createBookingBuilder = $createBookingBuilder;

        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->checkArray = $checkArray;
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->getPointService = $getPointService;
        $this->ticketReservationService = $ticketReservationService;
        $this->payments = $payments;
    }


    public function createBooking(CreateBookingRequest $request){
        // dd(auth()->user()->id);
        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];
        $contactInfoList = $validated["contactInfoList"];
        $airTravelerListChild = $validated['airTravelerChildList']; 
        $requestPurpose = $request->input('requestPurpose');
        $specialServiceRequestList = $validated['specialServiceRequestList'];
        $otherServiceInformationList = $validated['otherServiceInformationList'];
        $tripType = $request->input('trip_type');
        $preferredCurrency = $request->input('preferred_currency');
        
        // dd($CreateBookOriginDestinationOptionList);
        $xml = $this->createBookingBuilder->createBooking(
            $preferredCurrency,
            $CreateBookOriginDestinationOptionList,
            $contactInfoList,
            $airTravelerList,
            $airTravelerListChild,
            $requestPurpose,
            $otherServiceInformationList,
            $specialServiceRequestList
        );

      

        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

            

            if (!array_key_exists('AirBookingResponse', $response)) {

               Log::error('ERROR CREATING BOOKING WITH EXTERNAL API', [
                    'message' => $response,
                ]);

                // $stringResponse = json_encode($response, JSON_PRETTY_PRINT);

                return response()->json([
                    "error" => true,
                    "message" => "booking is no longer available for this flight",
                    // "message" =>  "error {$stringResponse}",
                   
                ], 404);

            } 
        
            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"];
            $timeLimit = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimit"];
            $timeLimitUTC = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimitUTC"];
            $bookingId = $bookingReferenceIDList['ID'];
            $bookingReferenceID = $bookingReferenceIDList['referenceID'];
            $user = $request->user();
            
            $surname = '';
            $guestToken = !$user ? $request->session()->get('guest_session_token') : null;
            $guestToken = $request->input('guest_session_token');


            // read expected amount from ticketReservation (this is the accurate amount)
            $ticketReservationFunction = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            

            $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                $preferredCurrency,
                $bookingId,
                $bookingReferenceID
            );    
             
            $ticketReservationResponse = $this->craneOTASoapService->run($ticketReservationFunction, $xml);
            // dump($ticketReservationResponse);
            $expectedAmount = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
            $currency = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]['currency']["code"];
            

            $ticketItemList = $response['AirBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'];
            $bookOriginDestinationOptionList = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'];
            // $amount = $response["AirBookingResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];

            if ($this->checkArray->isAssociativeArray($bookOriginDestinationOptionList)) {
                $bookOriginDestinationOptionList = [$bookOriginDestinationOptionList];
            }
            if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                $ticketItemList = [$ticketItemList];
            }
        
            $ticketCount = 0;

            // create invoice table   // add booking_id
            $invoice = Invoice::create([
                'amount' => $expectedAmount,
                'booking_id' => $bookingReferenceIDList['ID'],
                'type' => 'flight',
                'is_paid' => false,
                'currency' => $currency
            ]);  

            
            foreach($ticketItemList as $ticketItem) {                
                foreach($bookOriginDestinationOptionList as $bookOriginDestinationOption) {
                    $arrival_time = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['arrivalDateTime'];
                    $departure_time = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['departureDateTime'];
                    $origin = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['departureAirport']['locationName'];
                    $destination = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationName'];
                    $originCity = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['departureAirport']['locationCode'];
                    $destinationCity = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationCode'];
                    $ticketType = $bookOriginDestinationOption["bookFlightSegmentList"]["bookingClass"]["cabin"];
                    $flightDistance = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']["distance"];
                    $flightNumber = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']["flightNumber"];                            
                    $flightSegmentId = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']["flightSegmentID"];
                    $flightDuration = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']["journeyDuration"];
                    $totalHours = $this->getFlightHours($flightDuration);
                    $bookingFlightReferenceId = $bookOriginDestinationOption['bookFlightSegmentList']['referenceID'];

                    $passengerName = $ticketItem['airTraveler']["personName"]["givenName"];
                    $passengerSurname = $ticketItem['airTraveler']["personName"]["surname"];
                    $passengerType = $ticketItem['airTraveler']['passengerTypeCode'];

                        // Passenger::create([
                        //     "user_id" => $user->id,
                        //     "passenger_name" => $passengerName,
                        //     "passenger_surname" => $passengerSurname,
                        //     "passenger_type" => $passengerName,
                        // ]);
                    

                    Flight::firstOrCreate([
                        'booking_flight_reference_id' => $bookingFlightReferenceId,
                    ],
                    [  
                        'origin' => $origin, 
                        'destination' => $destination,
                        'arrival_time' => $arrival_time, 
                        'departure_time'=> $departure_time,
                        'flight_number' => $flightNumber,
                        'peace_id' => $user->peace_id,
                        'guest_session_token' => $guestToken, 
                        'trip_type' => $tripType,
                        'booking_id' => $bookingId,
                        'origin_city' => $originCity,
                        'destination_city' => $destinationCity,
                        'ticket_type' => $ticketType,
                        'flight_distance' => $flightDistance,
                        'flight_duration' => $totalHours,
                        'payment_expires_at' => $timeLimit,
                        'amount' => $expectedAmount,
                        'currency' => $currency,
                        'invoice_id' => $invoice->id,  
                        
                    ]); 
                    
                    $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                    event(new UserActivityLogEvent($user, "Booking", $description));
                    $ticketCount += 1;
                
                }
            }
            
            $surname = $ticketItemList[0]['airTraveler']["personName"]["surname"];
        

            // }    

            Booking::create([
                'peace_id' => $user ? $user->peace_id : null,
                'last_name' => $surname,
                'booking_id' => $bookingId,
                'invoice_id' => $invoice->id,
                'booking_reference_id' => $bookingReferenceID,
                'guest_session_token' => $user ? null : $guestToken 
            ]); 

            // create invoice_items table
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product' => 'Ticket', 
                'quantity' => $ticketCount,
                'price' => $expectedAmount
            ]);
            
            $bookingDetails = [
                "booking_id" => $bookingReferenceIDList['ID'],
                "reference_id" => $bookingReferenceIDList['referenceID'],
                "invoice_id" => $invoice->id,
                "amount" => $expectedAmount,
                "booking_created_at" =>  Carbon::now()->format('Y-m-d-H-i-s'),
                "timeLimit" => Carbon::parse($timeLimit)->format('Y-m-d-H-i-s'),
                "timeLimitUTC" => Carbon::parse($timeLimitUTC)->format('Y-m-d-H-i-s')
            ];

            // dump($bookingDetails);
            // dd($response);
            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "amount" => $expectedAmount,
                "trip_type" => $tripType,
                "bookingDetails" => $bookingDetails,
                // "response" => $response
            ], 200);

        } catch (\Throwable $th) {

            Log::error('ERROR CREATING BOOKING', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }

    public function redeemTicketWithPeacePoint(RedeemPeacePointViewRequest $request) {

        try {
            $preferredCurrency = $request->input('preferred_currency');
            $routes = $request->input('routes');
           // domestic, regional, international
            $passengerLength = $request->input('passenger_length');
            // we should be able to retrieve the booking id and reference using the Booking model
            $bookingId = $request->input('booking_id');
            $bookingReferenceID = $request->input('booking_reference_id');
          
    
            $user = $request->user();


            $data = $this->ticketReservationService->viewBaseFarePaymentInfo([
                'routes' => $routes,
                'noOfPassengers' => $passengerLength,
                'preferredCurrency' => $preferredCurrency,
                'bookingId' => $bookingId,
                'bookingReferenceID' => $bookingReferenceID
            ]);
          
              
    
            return response()->json([
                "routes" => $routes,
                "passenger_length" => $passengerLength,
                "amount_remaining" => $data['amountRemaining'],
                "expected_amount" => $data['expectedAmount'],
                "redemption_point" => $data['redemptionPoint'],
                "total_redemption_point" => $data['totalRedemptionPoint'],
                "base_fare" => $data['baseFare'],
                "booking_id" => $bookingId,
                "booking_reference_id" => $bookingReferenceID,
                'preferred_currency' => $preferredCurrency
    
            ], 200);
        
        } catch (\Throwable $th) {

            Log::error('ERROR REDEEMING TICKET WITH PEACE POINT', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
       

    }


    public function verifyRedemptionPayment(RedeemPeacePointCommitRequest $request) {
        try {
          
            $ref = $request->input('ref_id');
            $preferredCurrency = $request->input('preferred_currency');
            $routes = $request->input('routes');
            $passengerLength = $request->input('passenger_length');
            // $expectedAmount = $request->input('expected_amount');
            $bookingId = $request->input('booking_id');
            $bookingReferenceID = $request->input('booking_reference_id');
            $userDevice = $request->input('device_type');
            $paymentChannel = $request->input('payment_channel');
            $paymentMethod = $request->input('payment_method');
            
            $user = $request->user();



            $data = $this->ticketReservationService->viewBaseFarePaymentInfo([
                'routes' => $routes,
                'noOfPassengers' => $passengerLength,
                'preferredCurrency' => $preferredCurrency,
                'bookingId' => $bookingId,
                'bookingReferenceID' => $bookingReferenceID
            ]);
    
            $amountRemaining = $data['amountRemaining'];
            
            $expectedAmount = $data['expectedAmount'];
            $redemptionPoint = $data['redemptionPoint'];
            $totalRedemptionPoint = $data['totalRedemptionPoint'];
           

            if ($amountRemaining > 0) {
        
                $paidAmount = 0;

                $payment = null;
                // for economy ticket redeemed with peace point, the amount_remaining is 0, hence no need to make payment
                if (!($ref == "not_applicable")) {

                    if ($paymentChannel == "paystack") {
                        $new_top_request = new VerificationService($ref);

                    } else if ($paymentChannel == "flutterwave") {
                        $new_top_request = new FlutterVerificationService($ref);
                    } else {
                        throw new Exception("Invalid payment channel");
                    }
                    
                    $verified_request = $new_top_request->run();
                    $paidAmount = $paymentChannel == "paystack" ? $verified_request["data"]["amount"] / 100 : $verified_request["data"]["amount"];
                    
                    $currency = $verified_request["data"]["currency"];
                   
                    $invoice = Invoice::create([
                        "booking_id" => $bookingId,
                        "amount" => $paidAmount,
                        "type" => "flight",
                        "is_paid" => true,
                        "currency" => $preferredCurrency   
                    ]); 

                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product' => 'ticket', 
                        'quantity' => '1',
                        'price' => $paidAmount
                    ]);
                  
                    $payment = $this->payments->createPayment([
                        'user_id' => $user->id,
                        'ref' => $ref,
                        'amount' => $paidAmount,
                        'currency' => $currency,
                        'channel' => $paymentChannel,
                        'method' => $paymentMethod,
                        'purpose' => 'flight booking',
                        'payment_status' => 'completed',
                        'booking_api_status' => 'processing',
                        'booking_id' => $bookingId,
                        'booking_reference_id' => $bookingReferenceID,
                        'invoice_id' => $invoice->id,
                    ]);
                    
                    if ( $paidAmount < $amountRemaining ) {
                        // Log::error($throwable->getMessage());

                        return response()->json([
                            "error" => false,
                            "message" => "fund payment for ticket is less than calculated"
                        ], 500);
                    }

                }
            }
            
            $xml = $this->ticketReservationRequestBuilder->ticketReservationCommit(
                $preferredCurrency,           
                $bookingId,
                $bookingReferenceID,           
                $expectedAmount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
              
            );

            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);

            if (!array_key_exists('AirTicketReservationResponse', $response)) {
                
                Log::error($response);

                return response()->json([
                    'error' => true,
                    'message' => "no new addition to ticket",
                    'paidAmount' => $paidAmount,
                    "response" => $response
                ], 500);
            }   

            if ($payment) {
                $payment->update([
                    'booking_api_status' => 'completed'
                ]);
            }

            $user->points -= $totalRedemptionPoint;
            $user->save();

            $invoice->is_paid = true;
            $invoice->save();

            // get the list of all the tickets 
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];
           
          

           
            // if (array_key_exists('couponInfoList', $ticketItemList)) {
            if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                $invoice_number = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['invNumber'];
               
                
                if (!array_key_exists('asvcSsr', $ticketItemList['couponInfoList'])) {                    
                     
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                    ], [
                        'amount' => $paidAmount,
                        'transaction_type' => $transactionType,
                        'ticket_type' => 'ticket',
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id,
                        'device_type' => $userDevice,
                        'is_flight' => true,
                        'currency' => $preferredCurrency,
                        'payment_channel' => $paymentChannel ?? "redeemed with point",
                        'payment_method' => $paymentMethod ?? "redeemed with point",
                    ]);                    
                
                } else { 
                                           
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                    ],
                    [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice,
                            'is_flight' => true,                            
                            'currency' => $preferredCurrency,
                            'payment_channel' => $paymentChannel ?? "redeemed with point",
                            'payment_method' => $paymentMethod ?? "redeemed with point",
                        ]
                    ); 
                    
                } 
            
            } else {

                foreach($ticketItemList as $ticketItem) {
                    $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                  
                    if (!array_key_exists('asvcSsr', $ticketItem['couponInfoList'])) {
                        // dump('non asvcSsr ran');
                                                  
                        Transaction::firstOrCreate([
                            "invoice_number" => $invoice_number,                            
                        ], [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'ticket_type' => 'ticket',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice,
                            'is_flight' => true,                            
                            'currency' => $preferredCurrency,
                            'payment_channel' => $paymentChannel ?? "redeemed with point",
                            'payment_method' => $paymentMethod ?? "redeemed with point",
                        ]);                          
                    
                    }
                    else {      
                                                    
                        Transaction::firstOrCreate([
                            "invoice_number" => $invoice_number,                            
                        ], [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice,
                            'is_flight' => true,                            
                            'currency' => $preferredCurrency,
                            'payment_channel' => $paymentChannel ?? "redeemed with point",
                            'payment_method' => $paymentMethod ?? "redeemed with point",
                        ]); 
                    }                
                }
            }

            $description = "made for a payment of {$paidAmount} for flight with booking id {$bookingId}";
            event(new UserActivityLogEvent($user, "ticket payment", $description));

            

            return response()->json([
                "error" => false,
                "message" => "payment for flight successful"
            ]);

        }  catch (\Throwable $th) {

            Log::error('ERROR VERIFYING REDEMPTION WITH PAYMENT', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            if ($th->getMessage() == "Invalid payment channel" || $th->getMessage() == "Payment already processed") {
                return response()->json([
                    'error' => true, 
                    'message' => $th->getMessage()
                ], 500);
            }

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }

    private function getFlightHours($flightDuration) {
        $hours = 0;
        $minutes = 0;

        if (preg_match('/PT(\d+H)?(\d+M)?/', $flightDuration, $matches)) {
            // Check if hours and minutes are present in the matched groups
            if (!empty($matches[1])) {
                $hours = (int) rtrim($matches[1], 'H');
            }
            if (!empty($matches[2])) {
                $minutes = (int) rtrim($matches[2], 'M');
            }
        }

        // Calculate total duration in hours
        $totalHours = $hours + ($minutes / 60);

        if (is_float($totalHours) && $totalHours != floor($totalHours)) {
            $totalHours = round($totalHours, 2);
        }

        return $totalHours;
    }
    
}
