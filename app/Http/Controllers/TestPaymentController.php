<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tier;
use App\Models\Wallet;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
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
            // dd($new_top_request);
            $verified_request = $new_top_request->run();
            
            $amount = $verified_request["data"]["amount"];

            // convert to naira (from kobo)
            $amount = $amount / 100;

            // return  $this->ticketReservationController->guestTicketReservationCommit($bookingId, $bookingReferenceID, $amount, $invoiceId);
            return  $this->ticketReservationController->guestTicketReservationCommit($bookingId, $bookingReferenceID, $amount, $invoiceId, 'Android');
        
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        
            return response()->json(['status' => false,  'message' => 'Error processing request'], 500);
        }
    }

    public function verifyTierRef(Request $request) {
        try {
            $request->validate([
                'ref_id' => 'required|string'
            ]);
            $ref = $request->input('ref_id');
            $user = $request->user();
            $userId = $user->id;
    
            //validate verifiedRequest;

            $new_top_request = new VerificationService($ref);
            $verified_request = $new_top_request->run();
           
            
            $paidAmount = $verified_request["data"]["amount"];
            $paidAmount = $paidAmount / 100;
          
            // create invoice table   // add booking_id
            $invoice = Invoice::create([
                'amount' => $paidAmount,
                'booking_id' => "not applicable",
                'is_paid' => true
            ]);            
            
            // convert to naira (from kobo)
            
            // dd("i ran");
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
                    "message" => "amount paid does not match a specific tier"
                ]);

            } else {
                $dayOfWeek = Carbon::now()->format('1');
            
                Transaction::create([
                    "invoice_number" => "not applicable",                        
                    'amount' => $paidAmount,
                    'transaction_type' => "tier purchase",
                    'peace_id' => $user->peace_id,
                    'ticket_type' => "Ancillary",
                    'user_id' => $user->id,
                    'invoice_id' => $invoice->id,
                    'device_type' => $userDevice->device_type ?? "ANDROID",
                    'day_of_week' => $dayOfWeek
                ]);   

               return $this->tierController->upgradeTier($userId, $tier->id);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        
            return response()->json(['status' => false,  'message' => 'Error processing request'], 500);
        }
    }
}
