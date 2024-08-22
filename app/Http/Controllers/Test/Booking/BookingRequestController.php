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
    
    public function __construct(BookingBuilder $bookingBuilder)
    {
      $this->bookingBuilder = $bookingBuilder;  
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

        dd($xml);
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
