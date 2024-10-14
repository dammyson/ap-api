<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\VoidTicketCommitRequest;
use App\Http\Requests\Ticket\VoidTicketPricingRequest;
use App\Services\Soap\VoidTicketRequestBuilder;

class VoidTicketController extends Controller
{
    protected $voidTicketRequestBuilder;

    public function __construct(VoidTicketRequestBuilder $voidTicketRequestBuilder)
    {
        $this->voidTicketRequestBuilder = $voidTicketRequestBuilder;
    }
    
    public function voidTicketPricing(VoidTicketPricingRequest $request) {
        $bookingReferenceCompanyCityCode = $request->input('bookingReferenceCompanyCityCode');
        $bookingReferenceCompanyCode = $request->input('bookingReferenceCompanyCode');
        $bookingReferenceCompanyCodeContext = $request->input('bookingReferenceCompanyCodeContext');
        $bookingReferenceCompanyFullName = $request->input('bookingReferenceCompanyFullName');
        $bookingReferenceCompanyShortName = $request->input('bookingReferenceCompanyShortName');
        $bookingReferenceCompanyCountryCode = $request->input('bookingReferenceCompanyCountryCode');
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $parentBookingCompanyCityCode = $request->input('parentBookingCompanyCityCode');
        $parentBookingCompanyCode = $request->input('parentBookingCompanyCode');
        $parentBookingCodeContext = $request->input('parentBookingCodeContext');
        $parentBookingCompanyFullName = $request->input('parentBookingCompanyFullName');
        $parentBookingCompanyShortName = $request->input('parentBookingCompanyShortName');
        $parentBookingCountryCode = $request->input('parentBookingCountryCode');
        $parentBookingID = $request->input('parentBookingID');
        $parentBookingReferenceID = $request->input('parentBookingReferenceID');
        $operationType = $request->input('operationType');

     
        $xml = $this->voidTicketRequestBuilder->voidTicketPricing(
            $bookingReferenceCompanyCityCode,
            $bookingReferenceCompanyCode,
            $bookingReferenceCompanyFullName,
            $bookingReferenceCompanyCodeContext,
            $bookingReferenceCompanyShortName,
            $bookingReferenceCompanyCountryCode,
            $ID,
            $referenceID,
            $parentBookingCompanyCityCode,
            $parentBookingCompanyCode,
            $parentBookingCodeContext,
            $parentBookingCompanyFullName,
            $parentBookingCompanyShortName,
            $parentBookingCountryCode,
            $parentBookingID,
            $parentBookingReferenceID,
            $operationType

        );
         

        try {

            dd($xml);
        
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function voidTicketCommit(VoidTicketCommitRequest $request) {       
        $bookingId = $request->input('booking_id');
        $bookingReferenceId = $request->input('booking_reference_id');
        $parentBookingId = $request->input('parent_booking_id');
        $parentBookingReferenceId = $request->input('parent_booking_reference_id');


        $xml = $this->voidTicketRequestBuilder->voidTicketCommit(          
            $bookingId, 
            $bookingReferenceId,           
            $parentBookingId,
            $parentBookingReferenceId,

        );

        try {
          dd($xml);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
           
    }

}

