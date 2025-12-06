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
use App\Http\Requests\Test\Booking\CreateBookingRequest;
use App\Services\Utility\CheckArray;
use App\Services\Utility\GetPointService;
use App\Services\Soap\CreateBookingBuilder;
use App\Services\Wallet\VerificationService;
use App\Services\Wallet\FlutterVerificationService;
use App\Services\Soap\TicketReservationRequestBuilder;

class CreateBookingController extends Controller
{
    protected $createBookingBuilder;
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $checkArray;
    protected $ticketReservationRequestBuilder;
    protected $getPointService;

    public function __construct(CreateBookingBuilder $createBookingBuilder, TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray, GetPointService $getPointService) {
        $this->createBookingBuilder = $createBookingBuilder;

        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->checkArray = $checkArray;
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->getPointService = $getPointService;
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

    //    dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

            // dump($response);

            if (!array_key_exists('AirBookingResponse', $response)) {
                Log::error($response);

                return response()->json([
                    "error" => true,
                    "message" => "booking is no longer available for this flight",
                   
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


             //// read expected amount from ticketReservation (this is the accurate amount)
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
        
            $ticketCount = 0;

            // create invoice table   // add booking_id
            $invoice = Invoice::create([
                'amount' => $expectedAmount,
                'booking_id' => $bookingReferenceIDList['ID'],
                'is_paid' => false,
                'currency' => $currency
            ]);  

            if ($this->checkArray->isAssociativeArray($bookOriginDestinationOptionList)) {

                $flightSegment = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment'];

                $arrival_time = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['arrivalDateTime'];
                $departure_time = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['departureDateTime'];
                $origin = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['departureAirport']['locationName'];
                $destination = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationName'];
                // $arrivalAirportLocationCode = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationCode'];
                // $departureAirportLocationCode = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['departureAirport']['locationCode'];
                $originCity = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['departureAirport']['locationCode'];
                $destinationCity = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationCode'];
                $ticketType = $bookOriginDestinationOptionList["bookFlightSegmentList"]["bookingClass"]["cabin"];
                $flightDistance = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']["distance"];
                $flightNumber = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']["flightNumber"];                
                $flightDuration = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']["journeyDuration"];
                
                // $flightSegmentId = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']["flightSegmentID"];
                $bookingFlightReferenceId = $bookOriginDestinationOptionList['bookFlightSegmentList']['referenceID'];

                $totalHours = $this->getFlightHours($flightDuration);

                Flight::create([
                    'origin' => $origin, 
                    'destination' => $destination, 
                    'arrival_time' => $arrival_time, 
                    'departure_time'=> $departure_time,
                    'peace_id' => $user ? $user->peace_id : null, 
                    'guest_session_token' => $guestToken,
                    'trip_type' => $tripType,
                    'booking_id' => $bookingId,                        
                    'origin_city' => $originCity,
                    'destination_city' => $destinationCity,
                    'ticket_type' => $ticketType,
                    'flight_number' => $flightNumber,
                    'flight_distance' => $flightDistance,
                    'flight_duration' => $totalHours,
                    'payment_expires_at' => $timeLimit,
                    'invoice_id' => $invoice->id,
                    'booking_flight_reference_id' => $bookingFlightReferenceId,
                ]); 


                if ($this->checkArray->isAssociativeArray($ticketItemList)) {    
                    $passengerName = $ticketItemList['airTraveler']["personName"]["givenName"]; 
                    $passengerSurname = $ticketItemList['airTraveler']["personName"]["surname"];  
                    $passengerType = $ticketItemList['airTraveler']['passengerTypeCode'];              
                   
          
                    // Passenger::create([
                    //     "user_id" => $user->id,
                    //     "passenger_name" => $passengerName,
                    //     "passenger_surname" => $passengerSurname,
                    //     "passenger_type" => $passengerName,
                    // ]);

                    ///
                    $ticketCount += 1;
                    $surname = $ticketItemList['airTraveler']["personName"]["surname"];

                    $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                    event(new UserActivityLogEvent($user, "Booking", $description));

                } else {
                    foreach($ticketItemList as $ticketItem) {
                        $passengerName = $ticketItem['airTraveler']["personName"]["givenName"];  
                        $passengerSurname = $ticketItem['airTraveler']["personName"]["surname"]; 
                        $passengerType = $ticketItem['airTraveler']['passengerTypeCode']; 

                        // Passenger::create([
                        //     "user_id" => $user->id,
                        //     "passenger_name" => $passengerName,
                        //     "passenger_surname" => $passengerSurname,
                        //     "passenger_type" => $passengerName,
                        // ]);
                        

                        $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                        event(new UserActivityLogEvent($user, "Booking", $description));
                        
                        $ticketCount += 1;
                    }

                    $surname = $ticketItemList[0]['airTraveler']["personName"]["surname"];
                }

            } else {

                if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                    
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
                        $bookingFlightReferenceId = $bookOriginDestinationOption['bookFlightSegmentList']['referenceID'];

                        $totalHours = $this->getFlightHours($flightDuration);
                        $passengerName = $ticketItemList['airTraveler']["personName"]["givenName"];
                        $passengerSurname = $ticketItemList['airTraveler']["personName"]["surname"];
                        $passengerType = $ticketItemList['airTraveler']['passengerTypeCode'];

                        // Passenger::create([
                        //     "user_id" => $user->id,
                        //     "passenger_name" => $passengerName,
                        //     "passenger_surname" => $passengerSurname,
                        //     "passenger_type" => $passengerName,
                        // ]);


                        Flight::firstOrCreate([   
                            'booking_flight_reference_id' => $bookingFlightReferenceId,
                        ],[
                            'origin' => $origin, 
                            'destination' => $destination,
                            'arrival_time' => $arrival_time, 
                            'departure_time'=> $departure_time,
                            'invoice_id' => $invoice->id,
                            'peace_id' => $user->peace_id,
                            'guest_session_token' => $guestToken,
                            'trip_type' => $tripType,
                            'booking_id' => $bookingId,
                            'origin_city' => $originCity,
                            'destination_city' => $destinationCity,
                            'ticket_type' => $ticketType,
                            'flight_distance' => $flightDistance,
                            'flight_number' => $flightNumber,
                            'flight_duration' => $totalHours,
                            'payment_expires_at' => $timeLimit,
                        ]);  
                        
                        $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                        event(new UserActivityLogEvent($user, "Booking", $description));


                        $ticketCount += 1;
                    
                    }
                    $surname = $ticketItemList['airTraveler']["personName"]["surname"];

                    
                } else {
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
                                'invoice_id' => $invoice->id,  
                              
                            ]); 
                            
                            $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                            event(new UserActivityLogEvent($user, "Booking", $description));
                            $ticketCount += 1;
                        
                        }
                    }
                    
                    $surname = $ticketItemList[0]['airTraveler']["personName"]["surname"];
                }

            }    

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

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return response()->json([
                "error" => true,   
                "actual_message" => $e->getMessage(),         
                "message" => "something went wrong"
            ], 500);
        }
    }

    public function redeemTicketWithPeacePoint(Request $request) {

        try {
            $preferredCurrency = $request->input('preferred_currency');
            $routes = $request->input('routes');
            $class = $request->input('class');
            $type  = $request->input('type'); // domestic, regional, international
            $noOfPassengers = $request->input('passenger_length');
            // we should be able to retrieve the booking id and reference using the Booking model
            $bookingId = $request->input('booking_id');
            $bookingReferenceID = $request->input('booking_reference_id');
            $currency = $request->input('preferred_currency');
    
            $user = $request->user();
    
            // dd($routes);
            
            // return $this->getPointService->getFlightRedemptionPoints($route, $class, $type);
    
            // [$class, $points] = $this->getPointService->getFlightRedemptionPoints($route, $class, $type);
            // add a forloop here incase of multiple route
            $redemptionPoint = 0;
            foreach($routes as $route) {
                $redemptionPoint += $this->getPointService->getFlightRedemptionPoints($route['route'], $route['class'], $route['type']);
    
            }
            
            $totalRedemptionPoint = $redemptionPoint * $noOfPassengers; 
            $peacePoint = $user->points;
            // dd($totalRedemptionPoint, $peacePoint);
            
    
            if ($peacePoint < $totalRedemptionPoint) {
                return response()->json([
                    "error" => true,
                    "message" => "insufficient point"
                ], 500);
            }
            //// read expected amount from ticketReservation (this is the accurate amount)
            $ticketReservationFunction = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            
    
            $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                    $preferredCurrency,
                    $bookingId,
                    $bookingReferenceID
            );    
            
            $ticketReservationResponse = $this->craneOTASoapService->run($ticketReservationFunction, $xml);
            
            //substract base fare from expected amount to know how much the user is felt to pay
            $baseFare = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
            $expectedAmount = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
            $peacePointBalance = $peacePoint - $redemptionPoint;
            // dd($expectedAmount);
            // dd($baseFare);
    
            //dd($peacePointBalance);
            $ticketItemList = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]['ticketInfo']['ticketItemList'];
            
           $baseFare = 0;
          
            if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                // $baseFare = $ticketItemList['pricingInfo']['baseFare']['amount']['value'];
                
                $baseFare = $ticketItemList["pricingOverview"]["totalBaseFare"]["value"];
                // ["pricingOverview"]["totalAmount"]["value"];
    
            } else {
               foreach($ticketItemList as $ticketItem) {
                    // $baseFare += $ticketItem['pricingInfo']['baseFare']['amount']['value'];
                    $baseFare += $ticketItem["pricingOverview"]["totalBaseFare"]["value"];
                }
    
           }
    
    
           $amountRemaining = $expectedAmount - $baseFare;
    
        //    $totatBaseFare = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]['ticketInfo']['ticketItemList'][index]['couponInfoList']['pricingInfo']['equivBaseFare']['value'];
        //    $totalBaseFare = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]['ticketInfo']['ticketItemList'][index]['couponInfoList']['pricingOverview']['totalBaseFare']['value'];
    
            $invoice = Invoice::create([
                "booking_id" => $bookingId,
                "amount" => $amountRemaining,
                "is_paid" => false,
                "currency" => $preferredCurrency   
            ]);
            // $invoice->save();
    
    
            return response()->json([
                "amount_remaining" => $amountRemaining,
                "expected_amount" => $expectedAmount,
                "redemption_point" => $redemptionPoint,
                "base_fare" => $baseFare,
                "booking_id" => $bookingId,
                "booking_reference_id" => $bookingReferenceID,
                "invoice_id" => $invoice->id,
                'preferred_currency' => $preferredCurrency
    
            ], 200);
        
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return response()->json([
                "error" => true,    
                "actual_error" => $e->getMessage(),        
                "message" => "something went wrong"
            ], 500);
        }
       

    }


    public function verifyRedemptionPayment(Request $request) {
        try {
          
            $ref = $request->input('ref_id');
            $invoiceId = $request->input('invoice_id');
            $preferredCurrency = $request->input('preferred_currency');
            // $expectedAmount = $request->input('expected_amount');
            $bookingId = $request->input('booking_id');
            $bookingReferenceID = $request->input('booking_reference_id');
            $expectedAmount = $request->input('expected_amount');
            $userDevice = $request->input('device_type');
            $redemptionPoint = $request->input('redemption_point');
            $paymentChannel = $request->input('payment_channel');
            $paymentMethod = $request->input('payment_method');
            
            $user = $request->user();

            $invoice = Invoice::find($invoiceId);

            $invoiceAmount = $invoice->amount + 0;
            $paidAmount = 0;

            
            // for economy ticket redeemed with peace point, the amount_remaining is 0, hence no need to make payment
            if (!($ref == "not_applicable")) {

                if ($paymentChannel == "paystack") {
                    $new_top_request = new VerificationService($ref);

                } else if ($paymentChannel == "flutterwave") {
                    $new_top_request = new FlutterVerificationService($ref);
                }
                
                $verified_request = $new_top_request->run();
                $paidAmount = $paymentChannel == "paystack" ? $verified_request["data"]["amount"] / 100 : $verified_request["data"]["amount"];

                if ( $paidAmount < $invoiceAmount ) {
                    // Log::error($throwable->getMessage());

                    return response()->json([
                        "error" => false,
                        "message" => "fund payment for ticket is less than calculated"
                    ], 500);
                }

            }
             /////////////////////
            // dd("i got here");
            $xml = $this->ticketReservationRequestBuilder->ticketReservationCommit(
                $preferredCurrency,           
                $bookingId,
                $bookingReferenceID,           
                $expectedAmount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
              
            );
                
            $peaceId = $user->peace_id;          

            
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);

            // dump($response);

            if (!array_key_exists('AirTicketReservationResponse', $response)) {
                
                Log::error($response);

                return response()->json([
                    'error' => true,
                    'message' => "no new addition to ticket",
                    'paidAmount' => $paidAmount,
                    "response" => $response
                ], 500);
            }           
            
            $user->points -= $redemptionPoint;
            $user->save();


            
            $invoice->is_paid = true;
            $invoice->save();


            ///////////////////////
            
            // get the list of all the tickets 
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];
           
            // $userDevice = Device::where('user_id', $user->id)->first();

           
            // if (array_key_exists('couponInfoList', $ticketItemList)) {
            if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                $paymentReferenceID = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                $invoice_number = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                $paymentType = $ticketItemList['paymentDetails']['paymentDetailList']['paymentType'];
                $amount = $ticketItemList['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                $orderID = $ticketItemList['paymentDetails']['paymentDetailList']['orderID'];
                $ticketId = $ticketItemList['ticketDocumentNbr'];
                
                if (!array_key_exists('asvcSsr', $ticketItemList['couponInfoList'])) {                    
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']; // meant to be an array but an empty string when nothing is found;
                     
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
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                           
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
                    // if ($ticketItem["status"] == "OK") {
                        // dump($user->first_name);
                    $paymentReferenceID = $ticketItem['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                    $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                    $paymentType = $ticketItem['paymentDetails']['paymentDetailList']['paymentType'];
                    $amount = $ticketItem['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                    $orderID = $ticketItem['paymentDetails']['paymentDetailList']['orderID'];
                    $ticketId = $ticketItem['ticketDocumentNbr'];
                    if (!array_key_exists('asvcSsr', $ticketItem['couponInfoList'])) {
                        // dump('non asvcSsr ran');
                       
                        $reasonForIssuance = $ticketItem['reasonForIssuance']; // meant to be an array but an empty string when nothing is found;
                           
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
                        $reasonForIssuance = $ticketItem['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                                    
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

            
            ///////////////////////////
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product' => 'ticket', 
                'quantity' => '1',
                'price' => $paidAmount
            ]);

            return response()->json([
                "error" => false,
                "message" => "payment for flight successful"
            ]);

        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());
        
            return response()->json(['status' => false, 'actual_error' => $throwable->getMessage(), 'message' => "something went wrong"], 500);
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
