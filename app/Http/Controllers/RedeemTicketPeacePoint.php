<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Test\TicketReservationController;

class RedeemTicketPeacePoint extends Controller
{
    protected $ticketReservationController;

    public function __construct(TicketReservationController $ticketReservationController) {
        $this->ticketReservationController = $ticketReservationController;
    }

    public function payWithPeacePoint(Request $request) {
        try {
            $user = $request->user();
            $amount = $request->input('amount');
            $bookingId = $request->input('bookingId');
            $bookingReferenceID = $request->input('bookingReferenceID');
            $invoiceId = $request->input('invoiceId');
            $peacePoint = $user->peace_points;
    
            // convert peacepoint to naira
            // 1000Naira = 1peace_point;
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
            $result =  $this->ticketReservationController->ticketReservationCommit($bookingId, $bookingReferenceID, $amount, $invoiceId);
        
            // Commit the transaction
            DB::commit();
            // if successfully send mail with ticket information
            //Mail::send();

            return response()->json([
                "error" => false,
                "message" => "Points redemption successful",
                "used_peace_points" => $usedPeacePoint,
                "user_email" => $user->email
            ]);
        
        } catch (\Throwable $th) {
            // Rollback the transaction in case of an error
            DB::rollBack();
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ]);
        }
       
    }
}
