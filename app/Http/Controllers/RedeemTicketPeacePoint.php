<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\TicketReservations\TicketReservation;
use Illuminate\Support\Facades\Log;

class RedeemTicketPeacePoint extends Controller
{
    protected $ticketReservation;

    public function __construct(TicketReservation $ticketReservation, ) {
        $this->ticketReservation = $ticketReservation;
    }

    public function payWithPeacePoint(Request $request) {
        try {
            $user = $request->user();
            $amount = $request->input('amount');
            $bookingId = $request->input('bookingId');
            $bookingReferenceID = $request->input('bookingReferenceID');
            $invoiceId = $request->input('invoiceId');
            $deviceType = $request->input('device_type');
            $peacePoint = $user->peace_points;
    
            // convert peacepoint to naira
            // 1000Naira = 1 peace_point;
            $moneyEquivalent = $peacePoint * 1000;
    
            if ($moneyEquivalent < $amount) {
                return response()->json([
                    "error" => true,
                    "message" => "Oops... Sorry you do not have sufficient points to redeem ticket"
                ], 500);
            }
    
            // get number of peace point to use for payment
            $usedPeacePoint =  $amount / 1000;

            // Begin database transaction
            DB::beginTransaction();

            $user->peace_point = $peacePoint - $usedPeacePoint;
            $user->save();
    
            // make payment to the soap api
            $result = $this->ticketReservation->commit([
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceID,
                'paid_amount' => $amount,
                'invoice_id' => $invoiceId,
                'device_type' => $deviceType,
                'payment_method' => "bank transfer",
                'payment_channel' => "Quick teller",
                'preferred_currency' => "NGN"
            ]);   
            // Commit the transaction
            DB::commit();
            

            return response()->json([
                "error" => false,
                "message" => "Points redemption successful",
                "used_peace_points" => $usedPeacePoint,
                "user_email" => $user->email
            ]);
        
        }  catch (\Throwable $th) {

            Log::error('ERROR PAYING WITH PEACE POINT', [
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
