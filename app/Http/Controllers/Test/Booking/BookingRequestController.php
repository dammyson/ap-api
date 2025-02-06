<?php

namespace App\Http\Controllers\Test\Booking;

use stdClass;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Models\InvoiceRecord;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Utility\CheckArray;
use App\Services\Soap\BookingBuilder;
use App\Services\Utility\GetPointService;
use App\Http\Requests\Test\Booking\ReadBookingRequest;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Requests\Test\Booking\ReadBookingTkRequest;
use App\Http\Requests\Test\Booking\RetrievePNRHistoryRequest;
use App\Http\Requests\Test\Booking\RetrieveTicketHistoryRequest;

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

    public function readBookingTk(Request $request) {
        $bookingId = $request->input('ID');
        $peaceId = $request->input('peace_id');

        try {

            $booking = Booking::where('booking_id', $bookingId)->where('peace_id', $peaceId)->where('is_cancelled', false)->first();

            
            // dd($booking);
            if (!$booking) {
                return response()->json([
                    'error' => true,
                    'message' => 'no booking found'
                ], 500);
            }

            $invoice = Invoice::where('booking_id', $bookingId)->orderBy('created_at', 'desc')->first();
    
    
            $function = "http://impl.soap.ws.crane.hititcs.com/ReadBooking";

            $xml = $this->bookingBuilder->readBookingTK(
                $bookingId, 
                $booking->booking_reference_id
                // $booking->booking_reference_id
            );

            
            $response = $this->craneOTASoapService->run($function, $xml);
            // dd($response);
            
            $response = $this->craneOTASoapService->run($function, $xml);

            // dd($response);

            // return response()->json([
            //     "error" => false,
            //     "response" => $response
            // ]);

       
            if (isset($response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList']) &&
                $this->isAssociativeArray($response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList'])) {
                    // dd('I ran');
                    $response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList'] = 
                    [$response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList']];
            }

            $bookOriginDestinationOptionLists = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'];

            if (!$this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists)) {
                $filteredOptions = array_filter($bookOriginDestinationOptionLists, function ($option) {
                    return array_key_exists('bookFlightSegmentList', $option);
                });

                $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'] = $filteredOptions;

                foreach ($bookOriginDestinationOptionLists as $index => $bookOriginDestinationOptionList) {
                    $flightNotes = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['flightNotes'];
                    if(array_key_exists('deiCode', $flightNotes)) {
                        $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][$index]['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                        
                    }
                    
                }

            } else if (!$this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists) && count($bookOriginDestinationOptionLists) > 1) {
                
                foreach ($bookOriginDestinationOptionLists as $index => $bookOriginDestinationOptionList) {
                    $flightNotes = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['flightNotes'];
    
                    if(array_key_exists('deiCode', $flightNotes)) {
                        $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][$index]['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                    
                    }
                }

            } else {
                $flightNotes = $bookOriginDestinationOptionLists['bookFlightSegmentList']['flightSegment']['flightNotes'];

                if(array_key_exists('deiCode', $flightNotes)) {
                    $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                
                }
            }
            
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
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

    public function readBookingWithSurname(Request $request) {
        try {
            $bookingId = $request->input('booking_id');
            $passengerName = $request->input('surname');
            $function = "http://impl.soap.ws.crane.hititcs.com/ReadBooking";

            $xml = $this->bookingBuilder->readBooking($bookingId, $passengerName);

            $invoice = Invoice::where('booking_id', $bookingId)->orderBy('created_at', 'desc')->first();


            $response = $this->craneOTASoapService->run($function, $xml);

            // dd($response);

            if (isset($response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList']) &&
                $this->isAssociativeArray($response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList'])) {
                    // dd('I ran');
                    $response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList'] = 
                    [$response['AirBookingResponse']['airBookingList']['airReservation']['airTravelerList']];
            }

            $bookOriginDestinationOptionLists = $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'];

            if (!$this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists)) {
                $filteredOptions = array_filter($bookOriginDestinationOptionLists, function ($option) {
                    return array_key_exists('bookFlightSegmentList', $option);
                });

                $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'] = $filteredOptions;

                foreach ($bookOriginDestinationOptionLists as $index => $bookOriginDestinationOptionList) {
                    $flightNotes = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['flightNotes'];
                    if(array_key_exists('deiCode', $flightNotes)) {
                        $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][$index]['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                        
                    }
                    
                }

            } else if (!$this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists) && count($bookOriginDestinationOptionLists) > 1) {
                
                foreach ($bookOriginDestinationOptionLists as $index => $bookOriginDestinationOptionList) {
                    $flightNotes = $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['flightNotes'];
    
                    if(array_key_exists('deiCode', $flightNotes)) {
                        $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][$index]['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                    
                    }
                }

            } else {
                $flightNotes = $bookOriginDestinationOptionLists['bookFlightSegmentList']['flightSegment']['flightNotes'];

                if(array_key_exists('deiCode', $flightNotes)) {
                    $response['AirBookingResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['flightNotes'] = [$flightNotes];
                
                }
            }
            
       

        return response()->json([
            'error' => false,
            'invoice_id' => $invoice->id,
            'booking_data' => $response
        ]);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
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
            return $routes;


        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
       
    }
       
}
