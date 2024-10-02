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

class CreateBookingController extends Controller
{
    protected $createBookingBuilder;
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;

    public function __construct(CreateBookingBuilder $createBookingBuilder) {
        $this->createBookingBuilder = $createBookingBuilder;

        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
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

        $xml = $this->createBookingBuilder->createBookingOW(
            $CreateBookOriginDestinationOptionList, 
            $airTravelerList,
            $requestPurpose
        );
       
       
        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);
            
            // dd($response);

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

            $ticketCount = 1;
            
           
            FlightRecord::create([
                'origin' => $origin, 
                'destination' => $destination, 
                'arrival_time' => $arrival_time, 
                'departure_time'=> $departure_time,
                'peace_id' => $user->peace_id, 
                'passenger_type' => $ticketItemList['airTraveler']['passengerTypeCode'],
                'trip_type' => 'ONE_WAY',
                'booking_id' => $bookingId
            ]);                
            

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

                $arrival_time = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['arrivalDateTime'];
                $departure_time = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['departureDateTime'];
                $origin = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['arrivalAirport']['locationName'];
                $destination = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['departureAirport']['locationName'];
            
                // get the list of all the tickets 
                $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];


                foreach($ticketItemList as $ticketItem) {
                    
                    FlightRecord::create([
                        'origin' => $origin, 
                        'destination' => $destination, 
                        'arrival_time' => $arrival_time, 
                        'departure_time'=> $departure_time,
                        'peace_id' => $user->peace_id, 
                        'passenger_type' => $ticketItem['airTraveler']['passengerTypeCode'],
                        'trip_type' => 'ONE_WAY',
                        'booking_id' => $bookingId
                    ]);
                    
                }
                
                $bookingDetails = [
                    "bookingReferenceIDList" => $bookingReferenceIDList,
                    "timeLimit" => $timeLimit,
                    "timeLimitUTC" => $timeLimitUTC
                ];


                return response()->json([
                    "error" => false,
                    "message" => "Flight booked successfully",
                    "bookingDetails" => $bookingDetails
                ], 200);
            }

            

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
        return array_keys($array) == range(0, count($array) - 1);
    }
}
