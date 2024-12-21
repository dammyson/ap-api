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
        // $response = '';
        try {
            // dd('i ran');

            $ID = $request->input('ID'); 
            $referenceID = $request->input('referenceID');       
            // dd('I ran');
            $xml = $this->cancelBookingBuilder->cancelBookingCommit(            
                $ID, 
                $referenceID,
            );
    
            $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';
    
            $response = $this->craneOTASoapService->run($function, $xml);
            // dd($response);
            return response()->json([
                "error" => true,
                "message" => "booking cancelled"
            ], 200);
            
            if (array_key_exists('ticketInfo', $response['AirCancelBookingResponse']['airBookingList'])){
                return response()->json([
                    "error" => false,
                    "message" => "booking cancelled successfully, a refund amount will be decided when you visit the airline"
                ], 200);
                
               
            } else {
                return response()->json([
                    "error" => true,
                    "message" => "booking cancelled successfully"
                ], 400);   
            } 
        } catch (\Throwable $th) {
            response()->json([
                "error" => true,
                "message" => "something went wrong",
                // "response" => $response
            ], 500);
        }
       
        
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
