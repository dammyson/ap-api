<?php

namespace App\Http\Controllers\Test\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Booking\CancelBooking\CancelBookingCommitRequest;
use App\Http\Requests\Test\Booking\CancelBooking\CancelBookingViewOnlyRequest;
use App\Services\Soap\CancelBookingBuilder;
use App\Services\Utility\CheckArray;
use Illuminate\Http\Request;

class CancelBookingController extends Controller
{
    protected $cancelBookingBuilder;
    protected $craneOTASoapService;    
    protected $checkArray;

    public function __construct(CancelBookingBuilder $cancelBookingBuilder, CheckArray $checkArray)
    {
        $this->cancelBookingBuilder = $cancelBookingBuilder;
        $this->craneOTASoapService = app("CraneOTASoapService");
        $this->checkArray = $checkArray;

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
            
            $totalPenalty = 0;

            if (isset($response['AirCancelBookingResponse']['airBookingList']['ticketInfo'])) {
                if ($this->checkArray->isAssociativeArray($response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'])) {
                    dd($response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']['couponInfoList']);
                    $totalPenalty = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']['couponInfoList']['pricingOverview']['totalPenalty'];

                } else {
                    $ticketItemList = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'];
                    foreach($ticketItemList as $ticketItem) {
                        $totalPenalty += $ticketItem['pricingOverview']['totalPenalty']['value'];
                    }
                }
            }

            // display response of voiding a ticket to user
            dd($totalPenalty);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }
    }
}
