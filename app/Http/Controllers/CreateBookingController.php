<?php

namespace App\Http\Controllers;

use App\Events\UserActivityLogEvent;
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
use App\Services\Soap\CreateBookingTestBuilder;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Services\Utility\CheckArray;

class CreateBookingController extends Controller
{
    protected $createBookingBuilder;
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $checkArray;
    protected $createBookingTestBuilder;
    protected $ticketReservationRequestBuilder;

    public function __construct(CreateBookingBuilder $createBookingBuilder, CreateBookingTestBuilder $createBookingTestBuilder, TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray) {
        $this->createBookingBuilder = $createBookingBuilder;

        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->checkArray = $checkArray;
        $this->createBookingTestBuilder = $createBookingTestBuilder;
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
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

            BookingRecord::create([
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
                    FlightRecord::create([
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
                        'destination_city' => $destinationCity,
                        'ticket_type' => $ticketType,
                        'flight_number' => $flightNumber,
                        'flight_distance' => $flightDistance,
                        'flight_duration' => $totalHours,
                        'payment_expires_at' => $timeLimit,
                        'amount' => $expectedAmount
                    ]);  
                    $ticketCount += 1;

                    $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                    event(new UserActivityLogEvent($user, "Booking", $description));

                } else {
                    foreach($ticketItemList as $ticketItem) {
                        $passengerName = $ticketItem['airTraveler']["personName"]["givenName"];   
                        $passengerType = $ticketItem['airTraveler']['passengerTypeCode'];  

                        FlightRecord::create([
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
                            'amount' => $expectedAmount
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

                        FlightRecord::create([
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
                            'amount' => $expectedAmount
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

                            FlightRecord::create([
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
                                'amount' => $expectedAmount
                            ]); 
                            
                            $description = "booked a flight from {$origin} to {$destination} for {$passengerName} {($passengerType)}";
                            event(new UserActivityLogEvent($user, "Booking", $description));
                            $ticketCount += 1;
                        
                        }
                    }                    
                }

            }    

           
            
            // create invoice table   // add booking_id
            $invoice = InvoiceRecord::create([
                'amount' => $expectedAmount,
                'booking_id' => $bookingReferenceIDList['ID'],
                'is_paid' => false
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
