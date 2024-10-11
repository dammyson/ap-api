<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Test\TicketReservationController;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\Wallet\TopUpService;
use App\Services\Wallet\VerificationService;

class TestPaymentController extends Controller
{   
    protected $ticketReservationController;
    public function __construct(TicketReservationController $ticketReservationController)
    {
        $this->ticketReservationController = $ticketReservationController;
    }
   
    public function verify(Request $request)
    {
            
        try {
            $ref = $request->input('ref');
            $bookingId = $request->input('bookingId');
            $bookingReferenceID = $request->input('bookingReferenceID');
            $invoiceId = $request->input('invoiceId');
            
            
            //validate verifiedRequest;
            $new_top_request = new VerificationService($ref);
            $verified_request = $new_top_request->run();
            
            $amount = $verified_request["data"]["amount"];

            // convert from kobo back to Naira
            $amount = $amount / 100;

            return  $this->ticketReservationController->ticketReservationCommit($bookingId, $bookingReferenceID, $amount, $invoiceId);
            
            // return response()->json(['status' => true, 'data' =>  $top_up_result, 'message' => 'Wallet top up successfully'], 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['status' => false,  'message' => 'Error processing request'], 500);
        }
    }

}
