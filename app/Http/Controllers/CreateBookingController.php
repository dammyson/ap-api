<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use App\Models\FlightRecord;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Models\InvoiceRecord;
use App\Http\Controllers\Controller;
use App\Services\Soap\CreateBookingBuilder;
use App\Http\Requests\Test\Booking\CreateBookingOWRequest;
use App\Http\Requests\Test\Booking\CreateBookingRTRequest;
use App\Http\Requests\Test\Booking\CreateBookingTwoARequest;
use App\Services\Utility\CheckArray;

class CreateBookingController extends Controller
{
    protected $createBookingBuilder;
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $checkArray;

    public function __construct(CreateBookingBuilder $createBookingBuilder, CheckArray $checkArray) {
        $this->createBookingBuilder = $createBookingBuilder;

        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->checkArray = $checkArray;
    }

    public function createBookingRT(CreateBookingRTRequest $request) {
        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];        
        $requestPurpose = $request->input('requestPurpose');
        $capturePayment = $request->input('capturePayment');
        $paymentCode = $request->input('paymentCode');
        $threeDomainSecurityEligible = $request->input('threeDomainSecurityEligible');
        $MCONumber = $request->input('MCONumber');
        $paymentAmountCurrencyCode = $request->input('paymentAmountCurrencyCode');
        $paymentType = $request->input('paymentType');
        $primaryPayment = $request->input('primaryPayment');



        $xml = $this->createBookingBuilder->createBookingRT(            
            $CreateBookOriginDestinationOptionList,
            $airTravelerList,

            $requestPurpose,
            $capturePayment,
            $paymentCode,
            $threeDomainSecurityEligible,
            $MCONumber,
            $paymentAmountCurrencyCode,
            $paymentType,
            $primaryPayment
        );
        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);


            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"];
            dd($bookingReferenceIDList);

            // $result = "";
           

            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "booking_reference_id" =>$bookingReferenceIDList
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function createBookingOW(CreateBookingOWRequest $request) {
        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];
        $requestPurpose = $validated["requestPurpose"];
        $airTravelerSequence = $request->input('airTravelerSequence');
        $flightSegmentSequence = $request->input('flightSegmentSequence');
        $allowedQuantityPerPassenger = $request->input('allowedQuantityPerPassenger');
        $bundleRelatedSsr = $request->input('bundleRelatedSsr');
        $code = $request->input('code');
        $codeContext = $request->input('codeContext');
        $exchangeable = $request->input('exchangeable');
        $extraBaggage = $request->input('extraBaggage');
        $explanation = $request->input('explanation');
        $SSRFree = $request->input('SSRFree');
        $freeTextInRequest = $request->input('freeTextInRequest');
        $groupCode = $request->input('groupCode');
        $groupCodeExplanation = $request->input('groupCodeExplanation');
        $iciAllowed = $request->input('iciAllowed');
        $refundable = $request->input('refundable');
        $showOnItinerary = $request->input('showOnItinerary');
        $unitOfMeasureExist = $request->input('unitOfMeasureExist');
        $serviceQuantity = $request->input('serviceQuantity');
        $status = $request->input('status');

        $xml = $this->createBookingBuilder->createBookingOW(
            $CreateBookOriginDestinationOptionList, 
            $airTravelerList,
            $requestPurpose,
            $airTravelerSequence,
            $flightSegmentSequence,
            $allowedQuantityPerPassenger,
            $bundleRelatedSsr,
            $code,
            $codeContext,
            $exchangeable,
            $explanation,
            $extraBaggage,
            $SSRFree,
            $freeTextInRequest,
            $groupCode,
            $groupCodeExplanation,
            $iciAllowed,
            $refundable,
            $showOnItinerary,
            $unitOfMeasureExist,
            $serviceQuantity,
            $status
        );
       
       
        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);
            
            dd($response);

            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"];
            $timeLimit = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimit"];
            $timeLimitUTC = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimitUTC"];
            
            $bookingId = $bookingReferenceIDList['ID'];
            $bookingReferenceID = $bookingReferenceIDList['referenceID'];
            $user = $request->user();

            BookingRecord::create([
                'peace_id' => $user->peace_id,
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceID
            ]);

            $arrival_time = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['arrivalDateTime'];
            $departure_time = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['departureDateTime'];
            $origin = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationName'];
            $destination = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['departureAirport']['locationName'];
           
             // get the list of all the tickets 
             $ticketItemList = $response['AirBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'];
             $amount = $response["AirBookingResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
             $ticketCount = 0;
 
             if (!$this->isAssociativeArray($ticketItemList)) {
                 // dump('I associate ran');
                 foreach($ticketItemList as $ticketItem) {                    
                    
                    FlightRecord::create([
                        'origin' => $origin, 
                        'destination' => $destination, 
                        'arrival_time' => $arrival_time, 
                        'departure_time'=> $departure_time,
                        'peace_id' => $user->peace_id, 
                        'passenger_name' =>  $ticketItem['airTraveler']["personName"]["givenName"],
                        'passenger_type' => $ticketItem['airTraveler']['passengerTypeCode'],
                        'trip_type' => 'ONE_WAY',
                        'booking_id' => $bookingId
                    ]);
 
                    //dd('I ran');
                    $ticketCount += 1;            
                 }                        
             
             } else {
                 // dump('unassociative array ran');
                 
                 FlightRecord::create([
                     'origin' => $origin, 
                     'destination' => $destination, 
                     'arrival_time' => $arrival_time, 
                     'departure_time'=> $departure_time,
                     'peace_id' => $user->peace_id,
                     'passenger_name' =>  $ticketItemList['airTraveler']["personName"]["givenName"],
                     'passenger_type' => $ticketItemList['airTraveler']['passengerTypeCode'],                        
                     'trip_type' => 'ONE_WAY',
                     'booking_id' => $bookingId
                 ]);    
 
                 $ticketCount += 1;
 
             }             
            

            // create invoice table   // add booking_id
            $invoice = InvoiceRecord::create([
                'amount' => $amount,
                // 'order_id' => $orderID,                                
                // 'ticket_number' => $ticketId,
                'booking_id' => $bookingReferenceIDList['ID'],
                'is_paid' => false
            ]);
            

            // create invoice_items table
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product' => 'Ticket', // baggages or ticket shopping
                'quantity' => $ticketCount,
                // total_passengers => $totalPassengers  // this field would be removed
                'price' => $amount
            ]);

            $bookingDetails = [
                "booking_id" => $bookingReferenceIDList['ID'],
                "reference_id" => $bookingReferenceIDList['referenceID'],
                "invoice_id" => $invoice->id,
                "timeLimit" => $timeLimit,
                "timeLimitUTC" => $timeLimitUTC
            ];   
            

            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "booking_Detailsa" => $bookingDetails,
            ], 200);
            
            return response()->json($result);
        
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function createBookingTwoA(CreateBookingTwoARequest $request){
        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];
        $airTravelerListChild = $validated['airTravelerChildList']; 
        $requestPurpose = $request->input('requestPurpose');
        $specialServiceRequestList = $validated['specialServiceRequestList'];
        

        $xml = $this->createBookingBuilder->createBookingTwoA(
            $CreateBookOriginDestinationOptionList,
            $airTravelerList,
            $airTravelerListChild,
            $requestPurpose,
            $specialServiceRequestList
        );

       // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

            // dd($response);

            if (!array_key_exists('AirBookingResponse', $response)) {
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

            BookingRecord::create([
                'peace_id' => $user->peace_id,
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceID
            ]);

            $ticketItemList = $response['AirBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'];
            $bookOriginDestinationOptionList = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'];
            $amount = $response["AirBookingResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
        
            $ticketCount = 0;

            if ($this->checkArray->isAssociativeArray($bookOriginDestinationOptionList)) {
                $arrival_time = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['arrivalDateTime'];
                $departure_time = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['departureDateTime'];
                $origin = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationName'];
                $destination = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['departureAirport']['locationName'];
                
                if ($this->checkArray->isAssociativeArray($ticketItemList)) {                     
                    FlightRecord::create([
                        'origin' => $origin, 
                        'destination' => $destination, 
                        'arrival_time' => $arrival_time, 
                        'departure_time'=> $departure_time,
                        'peace_id' => $user->peace_id, 
                        'passenger_name' =>  $ticketItemList['airTraveler']["personName"]["givenName"],
                        'passenger_type' => $ticketItemList['airTraveler']['passengerTypeCode'],
                        'trip_type' => 'ONE_WAY',
                        'booking_id' => $bookingId
                    ]);  
                    $ticketCount += 1;

                } else {
                    foreach($ticketItemList as $ticketItem) {
                        FlightRecord::create([
                            'origin' => $origin, 
                            'destination' => $destination, 
                            'arrival_time' => $arrival_time, 
                            'departure_time'=> $departure_time,
                            'peace_id' => $user->peace_id, 
                            'passenger_name' => $ticketItem['airTraveler']["personName"]["givenName"],
                            'passenger_type' => $ticketItem['airTraveler']['passengerTypeCode'],
                            'trip_type' => 'ONE_WAY',
                            'booking_id' => $bookingId
                        ]); 
                        
                        $ticketCount += 1;
                    }
                }

            } else {

                if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                    
                    foreach($bookOriginDestinationOptionList as $bookOriginDestinationOption) {
                        $arrival_time = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['arrivalDateTime'];
                        $departure_time = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['departureDateTime'];
                        $origin = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationName'];
                        $destination = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['departureAirport']['locationName'];
                        
                        FlightRecord::create([
                            'origin' => $origin, 
                            'destination' => $destination, 
                            'arrival_time' => $arrival_time, 
                            'departure_time'=> $departure_time,
                            'peace_id' => $user->peace_id, 
                            'passenger_name' =>  $ticketItemList['airTraveler']["personName"]["givenName"],
                            'passenger_type' => $ticketItemList['airTraveler']['passengerTypeCode'],
                            'trip_type' => 'MULTI_CITY',
                            'booking_id' => $bookingId
                        ]);  

                        $ticketCount += 1;
                    
                    }
                    
                } else {
                    foreach($ticketItemList as $ticketItem) {
                        $passengeType = $ticketItem['airTraveler']['passengerTypeCode'];
                        $passengerName = $ticketItem['airTraveler']["personName"]["givenName"];
                        foreach($bookOriginDestinationOptionList as $bookOriginDestinationOption) {
                            $arrival_time = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['arrivalDateTime'];
                            $departure_time = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['departureDateTime'];
                            $origin = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationName'];
                            $destination = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']['departureAirport']['locationName'];
                            
                            FlightRecord::create([
                                'origin' => $origin, 
                                'destination' => $destination, 
                                'arrival_time' => $arrival_time, 
                                'departure_time'=> $departure_time,
                                'peace_id' => $user->peace_id, 
                                'passenger_name'=> $passengerName,
                                'passenger_type' => $passengeType,
                                'trip_type' => 'MULTI_CITY',
                                'booking_id' => $bookingId
                            ]); 
                            
                            $ticketCount += 1;
                        
                        }
                    }                    
                }

            }    

            // create invoice table   // add booking_id
            $invoice = InvoiceRecord::create([
                'amount' => $amount,
                'booking_id' => $bookingReferenceIDList['ID'],
                'is_paid' => false
            ]);            

            // create invoice_items table
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product' => 'Ticket', 
                'quantity' => $ticketCount,
                'price' => $amount
            ]);
            
            $bookingDetails = [
                "booking_id" => $bookingReferenceIDList['ID'],
                "reference_id" => $bookingReferenceIDList['referenceID'],
                "invoice_id" => $invoice->id,
                "amount" => $amount,
                "timeLimit" => $timeLimit,
                "timeLimitUTC" => $timeLimitUTC
            ];

            // dump($bookingDetails);
            // dd($response);
            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "amount" => "amount",
                "bookingDetails" => $bookingDetails,
                "response" => $response
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    

    private function isAssociativeArray($array) {
        // if the value is no at array at all return false;
        if (!is_array($array)) {
            return false;
        }

        // Check if the array is associative by looking at the keys
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
