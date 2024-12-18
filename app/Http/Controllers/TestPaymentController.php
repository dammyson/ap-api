<?php

namespace App\Http\Controllers;

use App\Models\Tier;
use App\Models\Wallet;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\InvoiceRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\Wallet\TopUpService;
use App\Services\Wallet\VerificationService;
use App\Http\Controllers\Test\TicketReservationController;

class TestPaymentController extends Controller
{   
    protected $ticketReservationController;
    protected $tierController;
    public function __construct(TicketReservationController $ticketReservationController, TierController $tierController)
    {
        $this->ticketReservationController = $ticketReservationController;
        $this->tierController = $tierController;
    }
   
    public function verifyTicketRef(Request $request)
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

            // convert to naira (from kobo)
            $amount = $amount / 100;

            return  $this->ticketReservationController->ticketReservationCommit($bookingId, $bookingReferenceID, $amount, $invoiceId);
            // dd()
            // return response()->json(['status' => true, 'data' =>  $top_up_result, 'message' => 'Wallet top up successfully'], 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        
            return response()->json(['status' => false,  'message' => 'Error processing request'], 500);
        }
    }

    public function verfiyTierRef(Request $request) {
        try {
            $request->validate([
                'amount' => 'required|string',
                'ref_id' => 'required|string'
            ]);
            $userId = $request->user()->id;
    
            //validate verifiedRequest;
            $new_top_request = new VerificationService($request->ref_id);
            $verified_request = $new_top_request->run();
            
            $paidAmount = $verified_request["data"]["amount"];
            // create invoice table   // add booking_id
            $invoice = InvoiceRecord::create([
                'amount' => $paidAmount,
                'booking_id' => "not applicable",
                'is_paid' => true
            ]);            
            
            // convert to naira (from kobo)
            $paidAmount = $paidAmount / 100;

            // create invoice_items table
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product' => 'tier', 
                'quantity' => '1',
                'price' => $paidAmount
            ]);
    
            if ($paidAmount == 3000) {
                $tier = Tier::where('name', 'Bronze')->first();
            } else if($paidAmount == 5000) {
                $tier = Tier::where('name', 'Silver')->first();
    
            } else if ($paidAmount == 7000) {
                $tier = Tier::where('name', 'Gold')->first();
    
            } else if($paidAmount == 9000) {
                $tier = Tier::where('name', 'Platinum')->first();
    
            }

            if(!$tier) {
                return response()->json([
                    "error" => true,
                    "message" => "amount paid doesnot match a specific tier"
                ]);
            } else {
                $this->tierController->upgradeTier($userId, $tier->id);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        
            return response()->json(['status' => false,  'message' => 'Error processing request'], 500);
        }
    }
}
