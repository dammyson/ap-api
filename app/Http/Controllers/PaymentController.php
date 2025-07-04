<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tier;
use App\Models\Wallet;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\Wallet\TopUpService;
use App\Services\Wallet\VerificationService;
use App\Services\Wallet\FlutterVerificationService;
use App\Http\Controllers\Soap\TicketReservationController;

class PaymentController extends Controller
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
            $preferredCurrency = $request->input('preferred_currency');
            $bookingId = $request->input('bookingId');
            $bookingReferenceID = $request->input('bookingReferenceID');
            $invoiceId = $request->input('invoiceId');
            $deviceType = $request->input('device_type');
            $paymentMethod = $request->input('payment_method');
            $paymentChannel = $request->input('payment_channel');
            
            
            //validate verifiedRequest;
            if ($paymentChannel == "paystack") {
                $new_top_request = new VerificationService($ref);

            } else if ($paymentChannel == "flutterwave") {
                $new_top_request = new FlutterVerificationService($ref);

            }
            $verified_request = $new_top_request->run();
            // dd($new_top_request);
            
            $amount = $verified_request["data"]["amount"];

            // convert to naira (from kobo)
            $amount = $paymentChannel == "paystack" ? $amount / 100 : $amount;

            // return  $this->ticketReservationController->ticketReservationCommit($bookingId, $bookingReferenceID, $amount, $invoiceId);
            return  $this->ticketReservationController->ticketReservationCommit($bookingId, $bookingReferenceID, $amount, $invoiceId, $deviceType, $paymentMethod, $paymentChannel, $preferredCurrency );
        
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    // public function verifyFlutterwave(Request $request) 
    // {   
        
    // }

    public function verifyTierRef(Request $request) {
        try {
            $request->validate([
                'ref_id' => 'required|string'
            ]);
            $preferredCurrency = $request->input('preferred_currency');
            $ref = $request->input('ref_id');
            $paymentMethod = $request->input('payment_method') ?? 'flutterwave';
            $paymentChannel = $request->input('payment_channel') ?? 'flutterwave';
            // $deviceType = $request->input('device_type');
            $user = $request->user();
            $userId = $user->id;
            // dd($preferredCurrency);
    
            //validate verifiedRequest;


             //validate verifiedRequest;
             if ($paymentChannel == "paystack") {
                $new_top_request = new VerificationService($ref);

            } else if ($paymentChannel == "flutterwave") {
                $new_top_request = new FlutterVerificationService($ref);

            }
            $verified_request = $new_top_request->run();
            // dd($new_top_request);
            
            $amount = $verified_request["data"]["amount"];

            // convert to naira (from kobo)
            $paidAmount = $paymentChannel == "paystack" ? $amount / 100 : $amount;
          
            // create invoice table   // add booking_id
            $invoice = Invoice::create([
                'amount' => $paidAmount,
                'booking_id' => "not applicable",
                'is_paid' => true,
                "currency" => $preferredCurrency
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
                $tier = Tier::where('name', 'Blue')->first();
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
            
                
                $response = $this->tierController->upgradeTier($userId, $tier->id);
                
                Transaction::create([
                    "invoice_number" => "not applicable",                        
                    'amount' => $paidAmount,
                    'transaction_type' => "tier purchase",
                    'user_id' => $user->id,
                    'ticket_type' => "Ancillary",
                    'user_id' => $user->id,
                    'invoice_id' => $invoice->id,
                    'device_type' => $user->device_type,
                    'currency' => $preferredCurrency,                                                
                    "payment_method" => $paymentMethod,
                    "payment_channel" => $paymentChannel,
                    'is_flight' => false
                ]);  
                
                return $response; 
            }
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message_error" => $th->getMessage()
                // "message" => "something went wrong",
            ], 500);
        }  
    }


    
}
