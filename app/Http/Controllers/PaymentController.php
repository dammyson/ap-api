<?php

namespace App\Http\Controllers;

use App\Exceptions\HititException;
use Carbon\Carbon;
use App\Models\Tier;
use App\Models\Wallet;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\Wallet\TopUpService;
use App\Services\Wallet\VerificationService;
use App\Services\Wallet\FlutterVerificationService;
use App\Services\TicketReservations\TicketReservation;
use App\Services\Payment\Payments;

class PaymentController extends Controller
{   
    protected $ticketReservationController;
    protected $tierController;
    protected $payments;
    protected $ticketReservation;

    public function __construct(Payments $payments, TicketReservation $ticketReservation, TierController $tierController)
    {
        $this->payments = $payments;
        $this->ticketReservation = $ticketReservation;
        $this->tierController = $tierController;
    }
   
    public function verifyTicketRef(Request $request)
    {
        try {

            $validated = $request->validate([
                'ref' => 'required|string',
                'preferred_currency' => 'required|string|in:USD,NGN,GBP',
                'bookingId' => 'required|string',
                'bookingReferenceID' => 'required|string',
                'invoiceId' => 'required|string',
                'device_type' => 'required|string',
                'payment_method' => 'required|string',
                'payment_channel' => 'required|string|in:paystack,flutterwave',
                'purpose' => 'sometimes|nullable|string',
            ]);

            $user = $request->user();

            $ref = $validated['ref'];
            $preferredCurrency = $validated['preferred_currency'];
            $bookingId = $validated['bookingId'];
            $bookingReferenceID = $validated['bookingReferenceID'];
            $invoiceId = $validated['invoiceId'];
            $deviceType = $validated['device_type'];
            $paymentMethod = $validated['payment_method'];
            $paymentChannel = $validated['payment_channel'];
            $purpose = $validated['purpose'] ?? null;
            
            
            
            //validate verifiedRequest;
            if ($paymentChannel == "paystack") {
                $new_top_request = new VerificationService($ref);

            } else if ($paymentChannel == "flutterwave") {
                $new_top_request = new FlutterVerificationService($ref);

            } else {
                throw new \Exception("Invalid payment channel");
            }
            $verified_request = $new_top_request->run();
            
            $amount = $verified_request["data"]["amount"];
            $paidCurrency = $verified_request['data']['currency'];

            // convert to naira (from kobo)
            $amount = $paymentChannel == "paystack" ? $amount / 100 : $amount;
        
            $payment = $this->payments->createPayment([
                'user_id' => $user->id,
                'ref' => $ref,
                'amount' => $amount,
                'currency' => $paidCurrency,
                'channel' => $paymentChannel,
                'method' => $paymentMethod,
                'purpose' => $purpose ?? 'flight booking|baggages',
                'payment_status' => 'completed',
                'booking_api_status' => 'processing',
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceID,
                'invoice_id' => $invoiceId,
            ]);

            
            return $this->ticketReservation->commit([
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceID,
                'paid_amount' => $amount,
                'invoice_id' => $invoiceId,
                'device_type' => $deviceType,
                'payment_method' => $paymentMethod,
                'payment_channel' => $paymentChannel,
                'preferred_currency' => $preferredCurrency,
                'payment_id' => $payment->id,
            ]);

        } catch (HititException $e) {
            Log::error('HITIT TICKET VERIFICATION ERROR', [
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
            
            Log::error('TICKET VERIFICATION ERROR', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            if (
                $th->getMessage() == "Payment verification failed" 
                || $th->getMessage() == "Payment already processed"
                || $th->getMessage() == "The selected payment channel is invalid."
                || $th->getMessage() == "Invalid payment channel") {

                return response()->json([
                    "error" => true,   
                    "message" => $th->getMessage(),                
                ], 500);
            }
            return response()->json([
                "error" => true,   
                "message" => "something went wrong",
             
            ], 500);
        }  
    }
   
    public function transactionList(Request $request)
    {
            
        try {

            $validated = $request->validate([               
                'bookingId' => 'required|string',
                
            ]);
            
            return Transaction::with('invoice')->where('booking_id', $validated['bookingId'])->get();           

            
            } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,   
                "message" => "something went wrong",
                "actual_message" => $th->getMessage()
             
            ], 500);
        }  
    }


    public function paymentList(Request $request)
    {
            
        try {
            
            return Payment::get();           

            
            } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,   
                "message" => "something went wrong",
                "actual_message" => $th->getMessage()
             
            ], 500);
        }  
    }

    // public function verifyFlutterwave(Request $request) 
    // {   
        
    // }

    public function verifyTierRef(Request $request) {
        try {
            $request->validate([
                'ref_id' => 'required|string',
                'payment_method' => 'required|string',
                'payment_channel' => 'required|string',
                'preferred_currency' => 'required|string'
            ]);
            $preferredCurrency = $request->input('preferred_currency');
            $ref = $request->input('ref_id');
            $paymentMethod = $request->input('payment_method');
            $paymentChannel = $request->input('payment_channel');
            // $deviceType = $request->input('device_type');
            $user = $request->user();
            $userId = $user->id;


             //validate verifiedRequest;
            if ($paymentChannel == "paystack") {
                $new_top_request = new VerificationService($ref);

            } else if ($paymentChannel == "flutterwave") {
                $new_top_request = new FlutterVerificationService($ref);

            } else {
                throw new \Exception("Invalid payment channel");
            }
            $verified_request = $new_top_request->run();
            
            $amount = $verified_request["data"]["amount"];
            $currency = $verified_request["data"]["currency"];

            // convert to naira (from kobo)
            $paidAmount = $paymentChannel == "paystack" ? $amount / 100 : $amount;
          
            // create invoice table   // add booking_id
            $invoice = Invoice::create([
                'amount' => $paidAmount,
                'booking_id' => "not applicable",
                'is_paid' => true,
                "currency" => $preferredCurrency
            ]);   
            
            
            $this->payments->createPayment([
                'user_id' => $user->id,
                'ref' => $ref,
                'amount' => $amount,
                'currency' => $currency,
                'channel' => $paymentChannel,
                'method' => "NaN",
                'purpose' => "Tier Upgrade",
                'payment_status' => 'completed',
                'booking_api_status' => 'NaN',
                'booking_id' => "NaN",
                'booking_reference_id' => "NaN"
            ]);


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

            Log::error('ERROR VERIFYING TIER REF', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            if ($th->getMessage() == "Invalid payment channel") {
                return response()->json([
                    'error' => true, 
                    'message' => $th->getMessage()
                ], 500); 
            }

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }


    
}
