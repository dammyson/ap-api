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
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $bookingBuilder;
    
    public function __construct(BookingBuilder $bookingBuilder)
    {
      $this->bookingBuilder = $bookingBuilder; 
      $this->craneOTASoapService = app('CraneOTASoapService');
      $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');  
    }

    public function retrievePNRHistory(RetrievePNRHistoryRequest $request) {
        $id = $request->input('ID');
       
        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAirBookingHistory';

        $xml = $this->bookingBuilder->retrievePNRHistory($id);

        $response = $this->craneOTASoapService->run($function, $xml);

        dd($response);

    }   


    public function RetrieveTicketHistory(RetrieveTicketHistoryRequest $request) {
        $bookingReferenceID = $request->input('bookingReferenceID');

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetTicketHistory';

        $xml = $this->bookingBuilder->RetrieveTicketHistory($bookingReferenceID);

        $response = $this->craneOTASoapService->run($function, $xml);

        dd($response);
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

        $function = 'http://impl.soap.ws.crane.hititcs.com/ReadBooking';

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

        dd($response);
    }

    public function readBooking(ReadBookingRequest $request) {
        $ID = $request->input('ID');
        $passengerSurname = $request->input('passengerSurname');

        $function = "http://impl.soap.ws.crane.hititcs.com/ReadBooking";

        $xml = $this->bookingBuilder->readBooking(
            $ID, 
            $passengerSurname
        );
        
        $response = $this->craneOTASoapService->run($function, $xml);

        dd($response);
    }
       
}
