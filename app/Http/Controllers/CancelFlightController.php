<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Wallet;
use App\Models\BookingRecord;
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
 
     public function changeFlightViewOnly(Request $request) {
         $peaceId = $request->input('peace_id');
         $bookingId = $request->input('booking_id');
 
         $booking = BookingRecord::where('peace_id', $peaceId)
             ->where('booking_id', $bookingId)->first();
 
        
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
             
 
             // display response of voiding a ticket to user
             dd($response);
 
             // if user clicks okay, void the ticket and refund money
 
             // provide the previous passenger info when the user searches for new flight
         } catch (\Throwable $th) {
             return response()->json([
                 "error" => "true",
                 "message" => $th->getMessage()
             ]);
         }
 
     }
 
    public function changeFlightCommit(Request $request) {
        $peaceId = $request->input('peace_id');
        $bookingId = $request->input('booking_id');


        $booking = BookingRecord::where('peace_id', $peaceId)
            ->where('booking_id', $bookingId)->first();

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
            
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $amount = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList']['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                        
            if ($transactionType == "REFUND") {
                
                $wallet = Wallet::where('user_id', $user->id);

                if($wallet) {
                    $wallet->topUp($amount);

                return response()->json([
                    "error" => false,
                    "message" => "refund successful"
                ], 200);
            } 
            }
         
         } catch (\Throwable $th) {
             return response()->json([
                 "error" => "true",
                 "message" => $th->getMessage()
             ], 500);
         }
     }
}
