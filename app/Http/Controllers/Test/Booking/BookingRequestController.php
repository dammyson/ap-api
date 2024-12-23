<?php

namespace App\Http\Controllers\Test\Booking;

use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Models\InvoiceRecord;
use App\Http\Controllers\Controller;
use App\Services\Soap\BookingBuilder;
use App\Http\Requests\Test\Booking\ReadBookingRequest;
use App\Http\Requests\Test\Booking\ReadBookingTkRequest;
use App\Http\Requests\Test\Booking\RetrievePNRHistoryRequest;
use App\Http\Requests\Test\Booking\RetrieveTicketHistoryRequest;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Services\Utility\CheckArray;
use App\Services\Utility\GetPointService;
use stdClass;

class BookingRequestController extends Controller
{
    protected $bookingBuilder;
    protected $ticketReservationRequestBuilder;
    protected $craneOTASoapService;
    protected $checkArray;
    protected $getPointService;
    
    public function __construct(BookingBuilder $bookingBuilder, TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray, GetPointService $getPointService)
    {
      $this->bookingBuilder = $bookingBuilder; 
      $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
      $this->craneOTASoapService = app("CraneOTASoapService");
      $this->checkArray = $checkArray;
      $this->getPointService;
      
    }

    public function readUserBookingTk(Request $request) {
        $bookingId = $request->input('booking_id');
        $peaceId = $request->input('peace_id');


        try {

            $booking = BookingRecord::where('booking_id', $bookingId)
                        ->where('peace_id', $peaceId)->where('is_cancelled', false)->first();

            $invoice = InvoiceRecord::where('booking_id', $bookingId)->orderBy('created_at', 'desc')->first();
    
            if (!$booking) {
                return response()->json([
                    'error' => true,
                    'message' => 'no booking found'
                ], 500);
            }

    
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            
    
            $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                $booking->booking_id,
                $booking->booking_reference_id
            );    
            
            $response = $this->craneOTASoapService->run($function, $xml);

            // dd($response);

            if (isset($response['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList']) &&
                $this->isAssociativeArray($response['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'])) {
                    // dd('I ran');
                    $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'] = 
                    [$response['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList']];
            }

            $bookOriginDestinationOptionLists = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'];

            if (!$this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists)) {
                $filteredOptions = array_filter($bookOriginDestinationOptionLists, function ($option) {
                    return array_key_exists('bookFlightSegmentList', $option);
                });

                $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'] = $filteredOptions;

                foreach ($bookOriginDestinationOptionLists as $index => $bookOriginDestinationOptionList) {
                    $flightNotes = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['flightNotes'];
                    if(array_key_exists('deiCode', $flightNotes)) {
                        $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][$index]['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                        
                    }
                    
                }

            } else if (!$this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists) && count($bookOriginDestinationOptionLists) > 1) {
                
                foreach ($bookOriginDestinationOptionLists as $index => $bookOriginDestinationOptionList) {
                    $flightNotes = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['flightNotes'];
    
                    if(array_key_exists('deiCode', $flightNotes)) {
                        $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][$index]['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                    
                    }
                }

            } else {
                $flightNotes = $bookOriginDestinationOptionLists['bookFlightSegmentList']['flightSegment']['flightNotes'];

                if(array_key_exists('deiCode', $flightNotes)) {
                    $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                
                }
            }
            
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }

        return response()->json([
            'error' => false,
            'invoice_id' => $invoice->id,
            'booking_data' => $response
        ]);

    }


    private function isAssociativeArray($array) {
        // if the value is no at array at all return false;
        if (!is_array($array)) {
            return false;
        }

        // Check if the array is associative by looking at the keys
        return array_keys($array) !== range(0, count($array) - 1);
    }


    public function retrievePNRHistory(RetrievePNRHistoryRequest $request) {
        $id = $request->input('ID');
       
        $xml = $this->bookingBuilder->retrievePNRHistory($id);

        dd($xml);

    }   


    public function RetrieveTicketHistory(RetrieveTicketHistoryRequest $request) {
        $bookingReferenceID = $request->input('bookingReferenceID');

        $xml = $this->bookingBuilder->RetrieveTicketHistory($bookingReferenceID);

        dd($xml);
    }

    public function readBookingTK(ReadBookingTkRequest $request) {
        $companyCityCode  = $request->input('companyCityCode'); 
        $companyCode = $request->input('companyCode'); 
        $companyNameCodeContext = $request->input('companyNameCodeContext');
        $companyFullName = $request->input('companyFullName'); 
        $companyShortName = $request->input('companyShortName'); 
        $countryCode = $request->input('countryCode'); 
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID'); 


        try {

            $function = "http://impl.soap.ws.crane.hititcs.com/ReadBooking";

            $xml = $this->bookingBuilder->readBookingTK(
                $ID, 
                $referenceID
            );

            
            $response = $this->craneOTASoapService->run($function, $xml);
            dd($response);
            
            $airTravelerLists = $response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList'];
            
            return response()->json([
                "error" => false,
                "passengersInfo" => $airTravelerLists
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ], 500);
        }
       
        return response()->json([
            "error" => false,
            "passengerInfo" => ""
        ], 200);
    }

    public function readBooking($ID, $referenceID) {
        try {
            $function = "http://impl.soap.ws.crane.hititcs.com/ReadBooking";
            
            $xml = $this->bookingBuilder->readBookingTK(
                $ID, 
                $referenceID
            );
            
            
            $response = $this->craneOTASoapService->run($function, $xml);
            // dd($response);
            
            $routes = [];
            $bookOriginDestinationOptionLists = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["airItinerary"]["bookOriginDestinationOptions"]["bookOriginDestinationOptionList"];
            // dd($bookOriginDestinationOptionLists);
            

            if (!$this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists)) {
                
                $filteredOptions = array_filter($bookOriginDestinationOptionLists, function ($option) {
                    return array_key_exists('bookFlightSegmentList', $option);
                }); 
    
                $response["AirBookingResponse"]["airBookingList"]["airReservation"]["airItinerary"]["bookOriginDestinationOptions"]["bookOriginDestinationOptionList"] = $filteredOptions;
                $bookOriginDestinationOptionLists = $filteredOptions;
                
                foreach($bookOriginDestinationOptionLists as $bookOriginDestinationOptionList) {
                    $class = $bookOriginDestinationOptionList["bookFlightSegmentList"]["bookingClass"]["resBookDesigCode"];
                    $fromCity = $bookOriginDestinationOptionList["bookFlightSegmentList"]["flightSegment"]["departureAirport"]["locationCode"];
                    $toCity = $bookOriginDestinationOptionList["bookFlightSegmentList"]["flightSegment"]["arrivalAirport"]["locationCode"];
    
                    $routes[] = [
                        "route" => "{$fromCity}-{$toCity}",
                        "class" => $class,
                        "fromCity" => $fromCity,
                        "toCity" => $toCity
                    ];
    
                //    $cities = new \stdClass();
                //    $cities->fromCity = $fromCity;
                //    $cities->toCity = $toCity;
                //    $routes[] = $cities;
                }

            } else {
                $fromCity = $bookOriginDestinationOptionLists["bookFlightSegmentList"]["flightSegment"]["departureAirport"]["locationCode"];
                $toCity = $bookOriginDestinationOptionLists["bookFlightSegmentList"]["flightSegment"]["arrivalAirport"]["locationCode"];
                $class = $bookOriginDestinationOptionLists["bookFlightSegmentList"]["bookingClass"]["resBookDesigCode"];

                $routes[] = [
                    "route" => "{$fromCity}-{$toCity}",
                    "class" => $class,
                    "fromCity" => $fromCity,
                    "toCity" => $toCity
                ];

                //    $cities = new \stdClass();
                //    $cities->fromCity = $fromCity;
                //    $cities->toCity = $toCity;
                //    $routes[] = $cities;
            }


        } catch (\Throwable $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ], 500);
        }

       
       return $routes;
    }
       
}
