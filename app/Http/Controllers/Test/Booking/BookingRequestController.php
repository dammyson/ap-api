<?php

namespace App\Http\Controllers\Test\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Booking\ReadBookingRequest;
use App\Http\Requests\Test\Booking\ReadBookingTkRequest;
use App\Http\Requests\Test\Booking\RetrievePNRHistoryRequest;
use App\Http\Requests\Test\Booking\RetrieveTicketHistoryRequest;
use App\Services\Soap\BookingBuilder;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{
    protected $bookingBuilder;
    protected $craneOTASoapService;
    
    public function __construct(BookingBuilder $bookingBuilder)
    {
      $this->bookingBuilder = $bookingBuilder; 
      $this->craneOTASoapService = app("CraneOTASoapService");
      
    }
//     php artisan config:clear
// php artisan cache:clear
// php artisan optimize:clear


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
                $companyCityCode, 
                $companyCode, 
                $companyNameCodeContext,
                $companyFullName, 
                $companyShortName, 
                $countryCode, 
                $ID, 
                $referenceID
            );

            
            $response = $this->craneOTASoapService->run($function, $xml);
            
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

    public function readBooking(ReadBookingRequest $request) {
        $ID = $request->input('ID');
        $passengerSurname = $request->input('passengerSurname');

        $xml = $this->bookingBuilder->readBooking(
            $ID, 
            $passengerSurname
        );

        dd($xml);
    }
       
}
