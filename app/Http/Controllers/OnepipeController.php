<?php

namespace App\Http\Controllers;

use App\Exceptions\HititException;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use App\Services\AutoGenerate\GenerateRandom;
use App\Http\Controllers\Soap\TicketReservationController;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\Payment\Payments;
use App\Services\TicketReservations\TicketReservation;
use Illuminate\Support\Facades\Log;

class OnepipeController extends Controller
{
    protected $generateRandom;
    protected $ticketReservationController;
    protected $payments;

    protected $ticketReservation;
    public function __construct(Payments $payments, TicketReservation $ticketReservation, GenerateRandom $generateRandom, TicketReservationController $ticketReservationController) {
        $this->generateRandom = $generateRandom;
        $this->ticketReservation = $ticketReservation;
        $this->ticketReservationController = $ticketReservationController;
        $this->payments = $payments;
    }

    public function generateVirtualAccount(Request $request) {

        try {

            $user = $request->user();
            
            $requestRef = $this->generateRandom->generateRandomNumber();
            $secret = config('app.one_pipe.secret');
            $bearerKey = config('app.one_pipe.bearer_key');
            $url = config('app.one_pipe.url');
            $signature = md5("{$requestRef};{$secret}");
            $user = $request->user();
            $bookingId = $request['booking_id'];
            $timeLimit = $request['time_limit'];
            $bookingCreatedAt = $request['booking_created_at'];
            $amount = $request['amount'];
            $transactionRef =  $this->generateRandom->generateRandomNumber();

        
            $response = Http::withHeaders([
                'Authorization' =>  'Bearer ' . $bearerKey, // move this to env once test is complete
                'Signature' => $signature, // md5 hash of ref;secret
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($url, [
                "request_ref"=> $requestRef,
                "request_type"=> "create_booking",
                "auth"=> [
                    "type"=> null,
                    "secure"=> null,
                    "auth_provider"=> null,
                    "route_mode"=> null
                ],
                "transaction"=> [
                    "mock_mode"=> "live",
                    "transaction_ref"=> $transactionRef,
                    "transaction_desc"=> "Account creation",
                    "transaction_ref_parent"=> null,
                    "amount"=> $amount,
                    "customer"=> [
                        "customer_ref"=> $user->id,
                        "firstname"=> $user->first_name,
                        "surname"=> $user->last_name,
                        "email"=> $user->email,
                        "mobile_no"=> $user->phone_number
                    ],
                    "meta"=> [
                        "merchant_id"=> $this->generateRandom->generateRandomNumber(),
                        "pnr"=> $bookingId,
                        "travel_date"=> "",                     
                        "currency"=> $request['currency']
                    ],
                    "details"=> [
                        "title"=> $user->title,
                        "reference_number"=> $this->generateRandom->generateRandomNumber(),
                        "service_number"=> "",
                        "booking_creation"=> $bookingCreatedAt, 
                        "booking_expiry" => $timeLimit                    
                    ]
                ]]);

                $booking = Booking::where('booking_id', $bookingId)->first();
                    
                if (!$booking) {
                    return response()->json([
                        "error" => true,
                        "message" => "please ensure bookingId is correct",
                    ], 400);
                }

                $booking->request_ref = $requestRef;
                $booking->save();
        
        } catch(\Throwable $th) {
            return response()->json([
                "error" => true,
                "actual_error" => $th->getMessage(),
                "message" => "something went wrong"
            ], 500);
        }        
      
        return response()->json([
            "error" => false,
            "data" => $response->body(),
            'booking_id' => $bookingId,
            "request_ref" => $requestRef,
            "transaction_ref" => $transactionRef
        ]);
     
    }

    public function queryPaymentStatus(Request $request) {
        
        $user = $request->user();
        $secret = config('app.one_pipe.secret');
        $bearerKey = config('app.one_pipe.bearer_key');
        $url = config('app.one_pipe.query_url');

        $requestRef = $request->input('request_ref');
        $bookingId = $request->input('booking_id');
        $signature = md5("{$request->input('request_ref')};{$secret}");


        $booking = Booking::where('booking_id', $bookingId)->first();

        if(!$booking) {
            return response()->json([
                "error" => true,
                "message" => "request ref does not match record"
            ], 400);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $bearerKey, // move this to env once test is complete
            'Signature' => $signature, // md5 hash of ref;secret
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post($url, [
            'request_ref' => $requestRef,
            'request_type' => 'create_booking',
            'auth' => [
                'type' => null,
                'secure' => null,
                'auth_provider' => null
            ],
            'transaction' => [
                'transaction_ref' => $request->input('transaction_ref')
            ]
        ]);
     
        $status = $response["status"];

        if ($status == 'Failed') {
            return response()->json([
                "error" => true,
                "message" => $response["message"]
            ], 400);
        }

        if ($status == 'PendingFulfilment') {
            return response()->json([
                "error" => true,
                "message" => $response["message"]
            ], 400);
        }

        if ($status != 'Successful') {
            return response()->json([
                "error" => true,
                "message" => $response["message"]
            ], 400);
        }

        $currency = $response["data"]["provider_response"]["meta"]["account"]["currency_code"];
        $bookingAmount = $response["data"]["provider_response"]["meta"]["booking_amount"];
        $paymentAmount = $response["data"]["provider_response"]["meta"]["payment_amount"];
        $deviceType = $request['device_type'];

 
        
        $flightInvoice = Invoice::where('booking_id', $bookingId)
            ->where('type', 'flight')
            ->latest()
            ->first();

            

        if (!$flightInvoice) {
            throw new \Exception("Flight invoice not found");
        }

        $payment = $this->payments->createPayment([
            'user_id' => $user->id,
            'ref' => $request->input('transaction_ref'),
            'amount' => $paymentAmount,
            'currency' => $currency,
            'channel' => "Quickteller",
            'method' => "Bank Transfer",
            'purpose' => $purpose ?? 'flight booking',
            'payment_status' => 'completed',
            'booking_api_status' => 'processing',
            'booking_id' => $bookingId,
            'invoice_id' => $flightInvoice->id,
            'booking_reference_id' => $booking->booking_reference_id
        ]);

       
        return $this->ticketReservation->commit([
            'booking_id' => $bookingId,
            'booking_reference_id' => $booking->booking_reference_id,
            'paid_amount' => $bookingAmount,
            'invoice_id' => $flightInvoice->id,
            'device_type' => $deviceType,
            'payment_method' => "bank transfer",
            'payment_channel' => "Quick teller",
            'preferred_currency' => $currency,
            'payment_id' => $payment->id,
        ]);   
    }

    public function paymentTransferCallback(Request $request) {
        $requestRef = $request['request_ref'];
        $requestType = $request['request_type'];
        $requester = $request['requester'];
        $amount = $request['details']['amount'];
        $provider = $request['details']['provider'];
        $status = $request['details']['status'];
        $customer_ref = $request['details']['customer_ref'];
        $customer_email = $request['details']['customer_email'];
        $transaction_ref = $request['details']['transaction_ref'];
        $customer_surname = $request['details']['customer_surname'];
        $customer_firstname = $request['details']['customer_firstname'];
        $transaction_desc = $request['details']['transaction_desc'];
        $transaction_type = $request['details']['transaction_type'];
        $customer_mobile_no = $request['details']['customer_mobile_no'];
        $reference_number = $request['details']['meta']['reference_number'];
        $service_number = $request['details']['meta']['service_number'];
        $pnr = $request['details']['meta']['pnr'];
        $transaction_date = $request['details']['meta']['transaction_date'];
        $transaction_date = $request['details']['meta']['transaction_date'];
        $booking_amount = $request['details']['meta']['booking_amount'];
        $appCode = $request['app_info']['app_code'];

        $hashedSignature = "md5(requestRef, env('app_secret'))";
        $signature = request().get_headers('Signature');

        return response()->json([
            "error" => false,
            "message" => "payment notification received"
        ], 200);


        if ($signature != $hashedSignature) {
            return response()->json([
                "error" => true,
                "message" => "header credentials dont match record"
            ], 403);
        } 

    }

    
    public function getInterswitchToken() {
        $getTokenUrl = "https://passport.k8.isw.la/passport/oauth/token?grant_type=client_credentials";
        
        $merchantId = config('app.quick_teller.merchant_id');
        $merchantSecret = config('app.quick_teller.merchant_secret');

        $token = base64_encode($merchantId . ':' . $merchantSecret);

      

        $response = Http::asForm()->withHeaders([
                    'Authorization' => 'Basic '. $token,
                ])->post($getTokenUrl, [
                    'grant_type' => 'client_credentials',
                ]);

       
        return $response->json()['access_token'];
        
      
    }

    public function verifyQuickTeller(Request $request) {

        try {

            // $merchantCode = $request->input('merchant_code');
            $transactionReference = $request->input('transaction_reference');
            $amount = $request->input('amount');
            $bookingId = $request->input('booking_id');
            $deviceType = $request->input('device_type');
            $purpose = $request->input('purpose');

            $url = config('app.quick_teller.url');
            $bearer = $this->getInterswitchToken();
          

            $booking = Booking::where('booking_id', $bookingId)->first();
            $user = $request->user();

            if(!$booking) {
                return response()->json([
                    "error" => true,
                    "message" => "request ref does not match record"
                ], 400);
            }


            //convert amount to kobo
            $amount = $amount * 100;

            $url = config('app.quick_teller.url');

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$bearer}", 
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->get("{$url}&transactionreference={$transactionReference}&amount={$amount}");
            
        
            $responseCode = $response["ResponseCode"];

            if ($responseCode == "00" ) {
                $currency = "NGN";
                $pnr = $booking->booking_id;                
                $deviceType = $request['device_type'];        
                // convert to naira (from kobo)
                $amount = $amount / 100;
        
                
            } else { 
                $currency = $response["data"]["provider_response"]["meta"]["account"]["currency_code"];
                $pnr = $response["data"]["provider_response"]["meta"]["pnr"];
                $amount = $response["data"]["provider_response"]["meta"]["booking_amount"];
                $deviceType = $request['device_type'];

                // convert to naira (from kobo)
                $amount = $amount / 100;
            }


            $payment = $this->payments->createPayment([
                'user_id' => $user->id,
                'ref' => $transactionReference,
                'amount' => $amount,
                'currency' => $currency,
                'channel' => "Quickteller",
                'method' => "Bank Transfer",
                'purpose' => $purpose ?? 'flight booking|baggages',
                'payment_status' => 'completed',
                'booking_api_status' => 'processing',
                'booking_id' => $bookingId,
                'booking_reference_id' => $booking->booking_reference_id
            ]);

            return $this->ticketReservation->commit([
                'booking_id' => $pnr,
                'booking_reference_id' => $booking->booking_reference_id,
                'paid_amount' => $amount,
                'invoice_id' => $booking->invoice_id,
                'device_type' => $deviceType,
                'payment_method' => "bank transfer",
                'payment_channel' => "Quick teller",
                'preferred_currency' => $currency,
                'payment_id' => $payment->id,
            ]);   
        
        } catch (HititException $e) {
            
            Log::error('HITIT ERROR WITH TICKET RESERVATION', [
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

        }  catch (\Throwable $th) {

            Log::error('ERROR VERIFYING QUICK TELLER', [
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
