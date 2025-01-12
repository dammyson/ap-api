<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Events\UserActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Services\Utility\CheckArray;
use App\Services\Utility\GetPointService;
use App\Services\Soap\CreateBookingBuilder;
use App\Services\Wallet\VerificationService;
use App\Services\Soap\CreateBookingTestBuilder;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Requests\Test\Booking\CreateBookingTwoARequest;

class CreateBookingController extends Controller
{
    protected $createBookingBuilder;
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $checkArray;
    protected $createBookingTestBuilder;
    protected $ticketReservationRequestBuilder;
    protected $getPointService;

    public function __construct(CreateBookingBuilder $createBookingBuilder, CreateBookingTestBuilder $createBookingTestBuilder, TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray, GetPointService $getPointService) {
        $this->createBookingBuilder = $createBookingBuilder;

        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->checkArray = $checkArray;
        $this->createBookingTestBuilder = $createBookingTestBuilder;
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->getPointService = $getPointService;
    }

    public function createBooking(CreateBookingTwoARequest $request){
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

    //    dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

        //    dd($response);

            if (!array_key_exists('AirBookingResponse', $response)) {
                return response()->json([
                    "error" => true,
                    "message" => "booking is no longer available for this flight",
                    "response" => $response
                   
                ], 404);

            } 
        
            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"];
            $timeLimit = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimit"];
            $timeLimitUTC = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimitUTC"];
            $bookingId = $bookingReferenceIDList['ID'];
            $bookingReferenceID = $bookingReferenceIDList['referenceID'];
            $user = $request->user();

            Booking::create([
                'peace_id' => $user->peace_id,
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceID
            ]);

             //// read expected amount from ticketReservation (this is the accurate amount)
            $ticketReservationFunction = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            

            $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                    $bookingId,
                    $bookingReferenceID
            );    
             
            $ticketReservationResponse = $this->craneOTASoapService->run($ticketReservationFunction, $xml);
            $expectedAmount = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
            

            $ticketItemList = $response['AirBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'];
            $bookOriginDestinationOptionList = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'];
            // $amount = $response["AirBookingResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
        
            $ticketCount = 0;

               // create invoice table   // add booking_id
            $invoice = Invoice::create([
                'amount' => $expectedAmount,
                'booking_id' => $bookingReferenceIDList['ID'],
                'is_paid' => false
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
                
                

                $totalHours = $this->getFlightHours($flightDuration);


                if ($this->checkArray->isAssociativeArray($ticketItemList)) {    
                    $passengerName = $ticketItemList['airTraveler']["personName"]["givenName"];   
                    $passengerType = $ticketItemList['airTraveler']['passengerTypeCode'];              
                    Flight::create([
                        'origin' => $origin, 
                        'destination' => $destination, 
                        'arrival_time' => $arrival_time, 
                        'departure_time'=> $departure_time,
                        'peace_id' => $user->peace_id, 
                        'passenger_name' =>  $passengerName,
                        'passenger_type' => $passengerType,
                        'trip_type' => 'ONE_WAY',
                        'booking_id' => $bookingId,                        
                        'origin_city' => $originCity,
                        'invoice_id' => $invoice->id,
                        'destination_city' => $destinationCity,
                        'ticket_type' => $ticketType,
                        'flight_number' => $flightNumber,
                        'flight_distance' => $flightDistance,
                        'flight_duration' => $totalHours,
                        'payment_expires_at' => $timeLimit
                    ]);  
                    $ticketCount += 1;

                    $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                    event(new UserActivityLogEvent($user, "Booking", $description));

                } else {
                    foreach($ticketItemList as $ticketItem) {
                        $passengerName = $ticketItem['airTraveler']["personName"]["givenName"];   
                        $passengerType = $ticketItem['airTraveler']['passengerTypeCode'];  

                        Flight::create([
                            'origin' => $origin, 
                            'destination' => $destination, 
                            'arrival_time' => $arrival_time, 
                            'departure_time'=> $departure_time,
                            'peace_id' => $user->peace_id, 
                            'passenger_name' => $passengerName,
                            'passenger_type' => $passengerType,
                            'trip_type' => 'ONE_WAY',
                            'booking_id' => $bookingId,
                            'origin_city' => $originCity,
                            'destination_city' => $destinationCity,
                            'ticket_type' => $ticketType,
                            'flight_number' => $flightNumber,
                            'flight_distance' => $flightDistance,
                            'flight_duration' => $totalHours,
                            'payment_expires_at' => $timeLimit,
                            'invoice_id' => $invoice->id

                        ]); 

                        $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                        event(new UserActivityLogEvent($user, "Booking", $description));
                        
                        $ticketCount += 1;
                    }
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
                        $flightDuration = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']["journeyDuration"];
                        
                        $totalHours = $this->getFlightHours($flightDuration);
                        $passengerName = $ticketItemList['airTraveler']["personName"]["givenName"];
                        $passengerType = $ticketItemList['airTraveler']['passengerTypeCode'];

                        Flight::create([
                            'origin' => $origin, 
                            'destination' => $destination, 
                            'arrival_time' => $arrival_time, 
                            'departure_time'=> $departure_time,
                            'peace_id' => $user->peace_id, 
                            'passenger_name' => $passengerName,
                            'passenger_type' => $passengerType,
                            'trip_type' => 'MULTI_CITY',
                            'booking_id' => $bookingId,
                            'origin_city' => $originCity,
                            'destination_city' => $destinationCity,
                            'ticket_type' => $ticketType,
                            'flight_distance' => $flightDistance,
                            'flight_number' => $flightNumber,
                            'flight_duration' => $totalHours,
                            'payment_expires_at' => $timeLimit,
                            'invoice_id' => $invoice->id

                        ]);  
                        
                        $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                        event(new UserActivityLogEvent($user, "Booking", $description));


                        $ticketCount += 1;
                    
                    }
                    
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
                            $flightDuration = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']["journeyDuration"];
                            
                            $passengerName = $ticketItem['airTraveler']["personName"]["givenName"];
                            $passengerType = $ticketItem['airTraveler']['passengerTypeCode'];
                            
                            $totalHours = $this->getFlightHours($flightDuration);

                            Flight::create([
                                'origin' => $origin, 
                                'destination' => $destination, 
                                'arrival_time' => $arrival_time, 
                                'departure_time'=> $departure_time,
                                'peace_id' => $user->peace_id, 
                                'passenger_name'=> $passengerName,
                                'passenger_type' => $passengerType,
                                'trip_type' => 'MULTI_CITY',
                                'booking_id' => $bookingId,
                                'origin_city' => $originCity,
                                'destination_city' => $destinationCity,
                                'ticket_type' => $ticketType,
                                'flight_distance' => $flightDistance,
                                'flight_number' => $flightNumber,
                                'flight_duration' => $totalHours,
                                'payment_expires_at' => $timeLimit,
                                'invoice_id' => $invoice->id
                            ]); 
                            
                            $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                            event(new UserActivityLogEvent($user, "Booking", $description));
                            $ticketCount += 1;
                        
                        }
                    }                    
                }

            }    

            

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
                "timeLimit" => $timeLimit,
                "timeLimitUTC" => $timeLimitUTC
            ];

            // dump($bookingDetails);
            // dd($response);
            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "amount" => $expectedAmount,
                "bookingDetails" => $bookingDetails,
                // "response" => $response
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function guestCreateBooking(CreateBookingTwoARequest $request){
        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];
        $airTravelerListChild = $validated['airTravelerChildList']; 
        $requestPurpose = $request->input('requestPurpose');
        $specialServiceRequestList = $validated['specialServiceRequestList'];
        $tripType = $request->input('trip_type');
        

        $xml = $this->createBookingBuilder->createBookingTwoA(
            $CreateBookOriginDestinationOptionList,
            $airTravelerList,
            $airTravelerListChild,
            $requestPurpose,
            $specialServiceRequestList
        );

    //    dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

               dump($response);

            if (!array_key_exists('AirBookingResponse', $response)) {
                return response()->json([
                    "error" => true,
                    "message" => "booking is no longer available for this flight",
                    "response" => $response
                   
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
                    $bookingId,
                    $bookingReferenceID
            );    
             
            $ticketReservationResponse = $this->craneOTASoapService->run($ticketReservationFunction, $xml);
            $expectedAmount = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
            

            $ticketItemList = $response['AirBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'];
            $bookOriginDestinationOptionList = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'];
            // $amount = $response["AirBookingResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
        
            $ticketCount = 0;

            // create invoice table   // add booking_id
            $invoice = Invoice::create([
                'amount' => $expectedAmount,
                'booking_id' => $bookingReferenceIDList['ID'],
                'is_paid' => false
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
                
                

                $totalHours = $this->getFlightHours($flightDuration);


                if ($this->checkArray->isAssociativeArray($ticketItemList)) {    
                    $passengerName = $ticketItemList['airTraveler']["personName"]["givenName"];   
                    $passengerType = $ticketItemList['airTraveler']['passengerTypeCode'];              
                    Flight::create([
                        'origin' => $origin, 
                        'destination' => $destination, 
                        'arrival_time' => $arrival_time, 
                        'departure_time'=> $departure_time,
                        'peace_id' => $user ? $user->peace_id : null, 
                        'guest_session_token' => $guestToken, 
                        'passenger_name' =>  $passengerName,
                        'passenger_type' => $passengerType,
                        'trip_type' => 'ONE_WAY',
                        'booking_id' => $bookingId,                        
                        'origin_city' => $originCity,
                        'destination_city' => $destinationCity,
                        'ticket_type' => $ticketType,
                        'flight_number' => $flightNumber,
                        'flight_distance' => $flightDistance,
                        'flight_duration' => $totalHours,
                        'payment_expires_at' => $timeLimit,
                        'invoice_id' => $invoice->id
                    ]);  
                    $ticketCount += 1;
                    $surname = $ticketItemList['airTraveler']["personName"]["surname"];

                    $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                    event(new UserActivityLogEvent($user, "Booking", $description));

                } else {
                    foreach($ticketItemList as $ticketItem) {
                        $passengerName = $ticketItem['airTraveler']["personName"]["givenName"];   
                        $passengerType = $ticketItem['airTraveler']['passengerTypeCode'];  

                        Flight::create([
                            'origin' => $origin, 
                            'destination' => $destination, 
                            'arrival_time' => $arrival_time, 
                            'departure_time'=> $departure_time,
                            'peace_id' => $user ? $user->peace_id : null, 
                            'guest_session_token' => $guestToken,
                            'passenger_name' => $passengerName,
                            'passenger_type' => $passengerType,
                            'trip_type' => 'ONE_WAY',
                            'booking_id' => $bookingId,
                            'origin_city' => $originCity,
                            'destination_city' => $destinationCity,
                            'ticket_type' => $ticketType,
                            'flight_number' => $flightNumber,
                            'flight_distance' => $flightDistance,
                            'flight_duration' => $totalHours,
                            'payment_expires_at' => $timeLimit,
                            'invoice_id' => $invoice->id
                        ]); 

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
                        $flightDuration = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']["journeyDuration"];
                        
                        $totalHours = $this->getFlightHours($flightDuration);
                        $passengerName = $ticketItemList['airTraveler']["personName"]["givenName"];
                        $passengerType = $ticketItemList['airTraveler']['passengerTypeCode'];

                        Flight::create([
                            'origin' => $origin, 
                            'destination' => $destination, 
                            'arrival_time' => $arrival_time, 
                            'departure_time'=> $departure_time,
                            'peace_id' => $user ? $user->peace_id : null, 
                            'guest_session_token' => $guestToken, 
                            'passenger_name' => $passengerName,
                            'passenger_type' => $passengerType,
                            'trip_type' => 'MULTI_CITY',
                            'booking_id' => $bookingId,
                            'origin_city' => $originCity,
                            'destination_city' => $destinationCity,
                            'ticket_type' => $ticketType,
                            'flight_distance' => $flightDistance,
                            'flight_number' => $flightNumber,
                            'flight_duration' => $totalHours,
                            'payment_expires_at' => $timeLimit,
                            'invoice_id' => $invoice->id
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
                            $flightDuration = $bookOriginDestinationOption['bookFlightSegmentList']['flightSegment']["journeyDuration"];
                            
                            $passengerName = $ticketItem['airTraveler']["personName"]["givenName"];
                            $passengerType = $ticketItem['airTraveler']['passengerTypeCode'];
                            
                            $totalHours = $this->getFlightHours($flightDuration);

                            Flight::create([
                                'origin' => $origin, 
                                'destination' => $destination, 
                                'arrival_time' => $arrival_time, 
                                'departure_time'=> $departure_time,
                                'peace_id' => $user ? $user->peace_id : null, 
                                'guest_session_token' => $guestToken, 
                                'passenger_name'=> $passengerName,
                                'passenger_type' => $passengerType,
                                'trip_type' => 'MULTI_CITY',
                                'booking_id' => $bookingId,
                                'origin_city' => $originCity,
                                'destination_city' => $destinationCity,
                                'ticket_type' => $ticketType,
                                'flight_distance' => $flightDistance,
                                'flight_number' => $flightNumber,
                                'flight_duration' => $totalHours,
                                'payment_expires_at' => $timeLimit,
                                'invoice_id' => $invoice->id
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
                "timeLimit" => $timeLimit,
                "timeLimitUTC" => $timeLimitUTC
            ];

            // dump($bookingDetails);
            // dd($response);
            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "amount" => $expectedAmount,
                "bookingDetails" => $bookingDetails,
                // "response" => $response
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function redeemTicketWithPeacePoint(Request $request) {
        $route = $request->input('route');
        $class = $request->input('class');
        $type  = $request->input('type'); // domestic, regional, international
        $noOfPassengers = $request->input('passenger_length');
        // we should be able to retrieve the booking id and reference using the Booking model
        $bookingId = $request->input('booking_id');
        $bookingReferenceID = $request->input('booking_reference_id');

        $user = $request->user();

        [$flightClass, $redemptionPoint] = $this->getPointService->getFlightRedemptionPoints($route, $class, $type);
        
        $totalRedemptionPoint = $redemptionPoint * $noOfPassengers; 
        $peacePoint = $user->peace_point;

        if ($peacePoint < $totalRedemptionPoint) {
            return response()->json([
                "error" => true,
                "message" => "insufficient point"
            ], 500);
        }
        //// read expected amount from ticketReservation (this is the accurate amount)
        $ticketReservationFunction = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            

        $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                $bookingId,
                $bookingReferenceID
        );    
        
        $ticketReservationResponse = $this->craneOTASoapService->run($ticketReservationFunction, $xml);
        

        //substract base fare from expected amount to know how much the user is felt to pay
        $baseFare = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
        $expectedAmount = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
        $peacePointBalance = $peacePoint - $redemptionPoint;

       
       $ticketItemList = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]['ticketInfo']['ticketItemList'];
        
       $baseFare = 0;
      
       if ($this->checkArray->isAssociativeArray($ticketItemList)) {
            if ($this->checkArray->isAssociativeArray($ticketItemList['couponInfoList'])) {
                $baseFare = $ticketItemList['couponInfoList']['pricingInfo']['baseFare']['amount']['value'];

            } else {
                foreach($ticketItemList['couponInfoList'] as $couponInfoList) {
                    $baseFare += $couponInfoList['pricingInfo']['baseFare']['amount']['value'];

                }
            }

       } else {
           foreach($ticketItemList as $ticketItem) {
                if ($this->checkArray->isAssociativeArray($ticketItem['couponInfoList'])) {
                    $baseFare += $ticketItem['couponInfoList']['pricingInfo']['baseFare']['amount']['value'];
                } else {
                    foreach($ticketItem['couponInfoList'] as $couponInfoList) {
                        $baseFare += $couponInfoList['pricingInfo']['baseFare']['amount']['value'];
                    }
                }
            }

       }

       $amountRemaining = $expectedAmount - $baseFare;

    //    $totatBaseFare = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]['ticketInfo']['ticketItemList'][index]['couponInfoList']['pricingInfo']['equivBaseFare']['value'];
    //    $totalBaseFare = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]['ticketInfo']['ticketItemList'][index]['couponInfoList']['pricingOverview']['totalBaseFare']['value'];

        $invoice = new Invoice();


        return [
            "amount_remaining" => $amountRemaining,
            "expected_amount" => $expectedAmount,
            "peace_point_balance" => $peacePointBalance,
            "booking_id" => $bookingId,
            "booking_reference_id" => $bookingReferenceID,
            "invoice_id" => $invoice->id

        ];

    }


    public function verifyTierRef(Request $request) {
        try {
            $request->validate([
                'ref_id' => 'required|string'
            ]);
            $ref = $request->input('ref_id');
            $user = $request->user();
            $userId = $user->id;
            $peacePoint = $request->input('peace_point');
            $expectedAmount = $request->input('expected_amount');
            $bookingId = $request->input('booking_id');
            $bookingReferenceID = $request->input('booking_reference_id');
            $deviceType = $request->input('device_type');
            $invoiceId = $request->input('invoice_id');
            //validate verifiedRequest;

            $new_top_request = new VerificationService($ref);
            $verified_request = $new_top_request->run();
           
            
            $paidAmount = $verified_request["data"]["amount"];
            $paidAmount = $paidAmount / 100;
          

            return  $this->ticketReservationController->guestTicketReservationCommit($bookingId, $bookingReferenceID, $expectedAmount, $invoiceId, $deviceType);

            // create invoice table   // add booking_id
            $invoice = Invoice::create([
                'amount' => $paidAmount,
                'booking_id' => "not applicable",
                'is_paid' => true
            ]);            
            
            // convert to naira (from kobo)
            
            // dd("i ran");
            // create invoice_items table
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product' => 'tier', 
                'quantity' => '1',
                'price' => $paidAmount
            ]);

    
            Transaction::create([
                "invoice_number" => "not applicable",                        
                'amount' => $paidAmount,
                'transaction_type' => "tier purchase",
                'peace_id' => $user->peace_id,
                'ticket_type' => "Ancillary",
                'user_id' => $user->id,
                'invoice_id' => $invoice->id,
                'device_type' => $user->device_type
            ]);   

            
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        
            return response()->json(['status' => false,  'message' => 'Error processing request'], 500);
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
