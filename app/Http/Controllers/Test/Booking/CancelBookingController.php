<?php

namespace App\Http\Controllers\Test\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Booking\CancelBooking\CancelBookingCommitRequest;
use App\Http\Requests\Test\Booking\CancelBooking\CancelBookingViewOnlyRequest;
use App\Services\Soap\CancelBookingBuilder;
use Illuminate\Http\Request;

class CancelBookingController extends Controller
{
    protected $cancelBookingBuilder;
    protected $craneOTASoapService;

    public function __construct(CancelBookingBuilder $cancelBookingBuilder)
    {
        $this->cancelBookingBuilder = $cancelBookingBuilder;
        $this->craneOTASoapService = app("CraneOTASoapService");

    }

    public function cancelBookingCommit(CancelBookingCommitRequest $request) {
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID');       
        // dd('I ran');
        $xml = $this->cancelBookingBuilder->cancelBookingCommit(            
            $ID, 
            $referenceID,
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';

        $response = $this->craneOTASoapService->run($function, $xml);
        dd($response);
        $amount = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['refundPaymentAmountList']['amount']['value'];
        dd($amount);
    }


    public function cancelBookingViewOnly(CancelBookingViewOnlyRequest $request) {
        
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID'); 

        $xml = $this->cancelBookingBuilder->cancelBookingViewOnly(          
            $ID, 
            $referenceID          
        );

        try {
            $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';

            $response = $this->craneOTASoapService->run($function, $xml);
            // dd('i ran');
            dd($response);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }
    }
}
