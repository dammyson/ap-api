<?php

namespace App\Http\Controllers\Test\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Booking\CancelBooking\CancelBookingCommitRequest;
use App\Http\Requests\Test\Booking\CancelBooking\CancelBookingViewOnlyRequest;
use App\Services\Soap\CancelBookingBuilder;
use Illuminate\Http\Request;

class CancelBookingController extends Controller
{
    
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $cancelBookingBuilder;

    public function __construct(CancelBookingBuilder $cancelBookingBuilder)
    {
        $this->cancelBookingBuilder = $cancelBookingBuilder; 
        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');

    }

    public function cancelBookingCommit(CancelBookingCommitRequest $request) {
        
        $cityCode = $request->input('cityCode'); 
        $code = $request->input('code'); 
        $codeContext = $request->input('codeContext'); 
        $companyFullName = $request->input('companyFullName'); 
        $companyShortName = $request->input('companyShortName'); 
        $countryCode = $request->input('countryCode'); 
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID'); 
        $requestPurpose = $request->input('requestPurpose'); 
      
        $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';

        $xml = $this->cancelBookingBuilder->cancelBookingCommit(
            $cityCode, 
            $code, 
            $codeContext, 
            $companyFullName, 
            $companyShortName, 
            $countryCode, 
            $ID, 
            $referenceID, 
            $requestPurpose
        );

        $response = $this->craneOTASoapService->run($function, $xml);

        dd($response);

    
    }

    public function cancelBookingViewOnly(CancelBookingViewOnlyRequest $request) {
        $cityCode = $request->input('cityCode'); 
        $code = $request->input('code'); 
        $codeContext = $request->input('codeContext'); 
        $companyFullName = $request->input('companyFullName'); 
        $companyShortName = $request->input('companyShortName'); 
        $countryCode = $request->input('companyShortName'); 
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID'); 
        $requestPurpose = $request->input('requestPurpose');


        $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';

        $xml = $this->cancelBookingBuilder->cancelBookingViewOnly(
            $cityCode, 
            $code, 
            $codeContext, 
            $companyFullName, 
            $companyShortName, 
            $countryCode, 
            $ID, 
            $referenceID,
            $requestPurpose
        );

        try {

            
        $response = $this->craneOTASoapService->run($function, $xml);
        
        dd($response);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }
    }
}
