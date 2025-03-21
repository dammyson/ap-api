<?php

namespace App\Http\Controllers;
use App\Models\Wallet;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use Illuminate\Support\Facades\Log;
use App\Services\Soap\CancelBookingBuilder;

class CancelFlightController extends Controller
{
     //
     protected $cancelBookingBuilder;
     protected $craneOTASoapService;
 
     public function __construct(CancelBookingBuilder $cancelBookingBuilder)
     {
         $this->cancelBookingBuilder = $cancelBookingBuilder;
         $this->craneOTASoapService = app('CraneOTASoapService');
     }
 
     public function cancelFlightViewOnly(Request $request) {
         $peaceId = $request->input('peace_id');
         $bookingId = $request->input('booking_id');
 
         $booking = Booking::where('peace_id', $peaceId)
             ->where('booking_id', $bookingId)->first();
        
             dd($booking);
        
         // user the what will be deducted and refunded after booking is canceled
 
         $xml = $this->cancelBookingBuilder->cancelBookingViewOnly(
             "LOS", 
             "P4", 
             "CRANE", 
             "SCINTILLA", 
             "SCINTILLA", 
             "NG", 
             $booking->booking_id, 
             $booking->booking_reference_id,
             "VIEW_ONLY"
         );
 
         try {
            $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';
 
            $response = $this->craneOTASoapService->run($function, $xml);

            dd($response);

            $airBookingList = $response['AirCancelBookingResponse']['airBookingList'];

            if (!array_key_exists('ticketInfo', $airBookingList)) {
                return response()->json([
                    "error" => false,
                    "message" => "money hasnt been paid for this ticket pls ignore it if you plan to cancel it"
                ], 200);
            }
             // display response of voiding a ticket to user
            $penaltyFee =  $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']["pricingOverview"]['totalPenalty']['value'];
            // dd($penaltyFee);
            
            $message = "Canceling this ticket after payment is made would cost you " . $penaltyFee;
             // if user clicks okay, void the ticket and refund money
 
            return response()->json([
                "error" => false,
                "message" => $message,
                "penalty_fee" => $penaltyFee
            ], 200);
             // provide the previous passenger info when the user searches for new flight
         } catch (\Throwable $th) {
             return response()->json([
                 "error" => "true",
                 "message" => $th->getMessage()
             ]);
         }
 
     }
 
    public function cancelFlightCommit(Request $request) {
        $peaceId = $request->input('peace_id');
        $bookingId = $request->input('booking_id');


        $booking = Booking::where('peace_id', $peaceId)
            ->where('booking_id', $bookingId)->first();

            // dd('I ran');

        $xml = $this->cancelBookingBuilder->cancelBookingCommit(
            $booking->booking_id, 
            $booking->booking_reference_id,
        );
 
        try {            
            $user = $request->user();
            $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';
            
            $response = $this->craneOTASoapService->run($function, $xml);
            // dd($response);

            $airBookingList = $response['AirCancelBookingResponse']['airBookingList'];

            if (!array_key_exists('ticketInfo', $airBookingList)) {
                return response()->json([
                    "error" => false,
                    "message" => "money hasnt been paid for this ticket pls ignore it if you plan to cancel it"
                ], 200);
            }
            $transactionType = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['pricingType'];
            // $amount = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
            $totalRefundAmount = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']['ticketItemList']['refundPricingInfo']['baseFare']['amount']['value'];; // amount paid for this transaction
            $penaltyFee =  $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']["pricingOverview"]['totalPenalty']['value'];
            
            if ($transactionType == "REFUND") {
                
                $wallet = Wallet::where('user_id', $user->id);


                if($wallet) {
                    // $wallet->topDown($penaltyFee);

                    $amountAddition = $totalRefundAmount - $penaltyFee;

                    if ($amountAddition > 0) {
                        $wallet->topUp($amountAddition);

                    }

                return response()->json([
                    "error" => false,
                    "message" => "flight cancel successfully"
                ], 200);
            } 
            }
         
         } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
     }
}
