<?php

namespace App\Http\Controllers\Soap\Booking;

use App\Exceptions\HititException;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Utility\CheckArray;
use App\Services\Soap\CancelBookingBuilder;
use App\Http\Requests\Soap\Booking\CancelBooking\CancelBookingCommitRequest;
use App\Http\Requests\Soap\Booking\CancelBooking\CancelBookingViewOnlyRequest;

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
        try {

            $user =  $request->user();

            $ID = $request->input('ID'); 
            $referenceID = $request->input('referenceID');

            
           
            $xml = $this->cancelBookingBuilder->cancelBookingCommit(            
                $ID, 
                $referenceID,
            );
    
            $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';
    
            $response = $this->craneOTASoapService->run($function, $xml);
           
            $userBooking = Booking::where('booking_id', $ID)->where('peace_id', $user->peace_id)->where('is_cancelled', false)->first();
              
            if (!$userBooking) {
                return response()->json([
                    "error" => true,
                    "message" => "booking does not exist for this user"
                ], 500);
            }
            
            Booking::where('booking_id', $ID)->update([
                'is_cancelled' => true
            ]);

            Transaction::where('booking_id', $ID)->update([
                'is_cancelled' => true,
                'status' => "cancelled",
                "is_refunded" => false,
            ]);

            if (array_key_exists('ticketInfo', $response['AirCancelBookingResponse']['airBookingList'])){

               
                return response()->json([
                    "error" => false,
                    "message" => "booking cancelled successfully, a refund amount will be decided when you visit the airline"
                ], 200);
                
               
            } else {

             
                return response()->json([
                    "error" => false,
                    "message" => "booking cancelled successfully"
                ], 200);   
            } 


        } catch (HititException $e) {
            
            Log::error('HITIT ERROR CANCELLING BOOKING', [
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
            ], 400);

        } catch (\Throwable $th) {

            Log::error('ERROR CANCELLING BOOKING', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
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
                    $totalPenalty = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']['couponInfoList']['pricingOverview']['totalPenalty'];

                } else {
                    $ticketItemList = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'];
                    foreach($ticketItemList as $ticketItem) {
                        $totalPenalty += $ticketItem['pricingOverview']['totalPenalty']['value'];
                    }
                }
            }


            return response()->json([
                "total_penalty" => $totalPenalty,
                "message" => "A fee of {$totalPenalty} wil be deducted from your refund",
                "response" => $response
            ]);
        } catch (HititException $e) {
            
            Log::error('HITIT ERROR VIEWING CANCEL BOOKING', [
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
            ], 400);

        } catch (\Throwable $th) {

            Log::error('ERROR VIEWING CANCEL BOOKING', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }
}
