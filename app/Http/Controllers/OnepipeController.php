<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use App\Services\AutoGenerate\GenerateRandom;
use App\Http\Controllers\Test\TicketReservationController;

class OnepipeController extends Controller
{
    protected $generateRandom;
    protected $ticketReservationController;

    public function __construct(GenerateRandom $generateRandom, TicketReservationController $ticketReservationController) {
        $this->generateRandom = $generateRandom;
        $this->ticketReservationController = $ticketReservationController;
    }

    public function generateVirtualAccount(Request $request) {
        $user = $request->user();
        // dd(now());
        $requestRef = $this->generateRandom->generateRandomNumber();
        $secret = env('SECRET');
        $signature = md5("{$requestRef};{$secret}");
        $user = $request->user();
      
        $response = Http::withHeaders([
            // 'Authorization' => env('BEARER_API_KEY'), // move this to env once test is complete
            'Authorization' => "Bearer JpPRs4kYiv99mYZRluo4_5b57e19da0fb4e679aa42cc1bfa173e1", // move this to env once test is complete
            'Signature' => $signature, // md5 hash of ref;secret
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://api.paygateplus.ng/v2/transact', [
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
                "transaction_ref"=> $this->generateRandom->generateRandomNumber(),
                "transaction_desc"=> "Account creation",
                "transaction_ref_parent"=> null,
                "amount"=> $request['amount'],
                "customer"=> [
                    "customer_ref"=> $user->id,
                    "firstname"=> $user->first_name,
                    "surname"=> $user->last_name,
                    "email"=> $user->email,
                    "mobile_no"=> $user->phone_number
                ],
                "meta"=> [
                    "merchant_id"=> $this->generateRandom->generateRandomNumber(),
                    "pnr"=> $request['booking_id'],
                    "travel_date"=> "",                     
                    "currency"=> $request['currency']
                ],
                "details"=> [
                    "title"=> $user->title,
                    "reference_number"=> $this->generateRandom->generateRandomNumber(),
                    "service_number"=> "",
                    "booking_creation"=> "", 
                    "booking_expiry" => ""                    
                ]
            ]]);


        // dd($response->body());
        
      
        return response()->json([
            "error" => false,
            "data" => $response->body()
        ], $response->status());
     
    }

    public function queryPaymentStatus(Request $request) {
        $bankName = $request['bank_name'];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer JpPRs4kYiv99mYZRluo4_5b57e19da0fb4e679aa42cc1bfa173e1', // move this to env once test is complete
            'Signature' => '284d315f16869a74e0c84395ef642987', // md5 hash of ref;secret
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post('https://api.paygateplus.ng/v2/transact/query', [
            'request_ref' => '1234567899',
            'request_type' => 'create_booking',
            'auth' => [
                'type' => null,
                'secure' => null,
                'auth_provider' => null
            ],
            'transaction' => [
                'transaction_ref' => '2222222222222'
            ]
        ]);
        
        // or dd($response->json()) to debug
        // return $response;
     
        $status = $response["status"];

        if ($status == 'PendingFulfilment') {
            return response()->json([
                "error" => true,
                "message" => "payment is pending fulfilment"
            ], 400);
        }

        if ($status != 'Successful') {
            return response()->json([
                "error" => true,
                "message" => "transfer was unsuccesful"
            ], 400);
        }

        $currency = $response["data"]["provider_response"]["meta"]["account"]["currency_code"];
        $pnr = $response["data"]["provider_response"]["meta"]["pnr"];
        $amount = $response["data"]["provider_response"]["meta"]["booking_amount"];
        $booking = Booking::where('booking_id', $pnr)->first();
        $deviceType = $request['device_type'];

        // convert to naira (from kobo)
        $amount = $amount / 100;

        // dd(["currecny" => $currency, "pnr" => $pnr, "amount" => $amount, "bookingReference" => $booking->booking_reference_id, "invoice_id" => $booking->invoice_id, "deviceType" => $deviceType]);
                            
        return  $this->ticketReservationController->guestTicketReservationCommit("bank transfer", $bankName , $currency, $pnr, $booking->booking_reference_id, $amount, $booking->invoice_id, $deviceType);

    }

    public function paymentTransferCallback(Request $request) {
        /*
        curl --location '' \
        --header 'Content-Type: application/json' \
        --header 'Signature:  {{MD5Hash(request_ref;app_secret)}}' \
        --data-raw '{
            "request_ref": "{{request_ref}}",
            "request_type": "transaction_notification",
            "requester": "FidelityVirtual",
            "mock_mode": "live",
            "details": {
                "amount": 10000000,
                "status": "Successful",
                "provider": "FidelityVirtual",
                "customer_ref": "2347012382234",
                "customer_email": "johndoe@gmail.com",
                "transaction_ref": "{{transaction_ref}}",
                "customer_surname": "John",
                "customer_firstname": "Doe",
                "transaction_desc": "{{transaction_description}}",
                "transaction_type": "collect",
                "customer_mobile_no": "2347012382234",
                "meta": {
                    "reference_number": "70279922332",
                    "service_number": "PHCLOS",
                    "pnr": "AVLP6D",
                    "transaction_date": "2022-11-18-11-41-58",
                    "booking_amount": 10000000
                },
                "data": {}
            },
            "app_info": {
                "app_code": "{{your_app_code}}"
            }
        }'
        */

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

     
        // if ($status == 'Failed') {
        //     return response()->json([
        //         "error" => true,
        //         "message" => "Payment failed"
        //     ], 400);
        // }

        // // read booking amount from crane
        // if ($amount < ) {
        //     return response()->json([
        //         "error" => true,
        //         "message" => "insufficient amount paid. Please contact office for refunded"
        //     ], 400);
        // }      



    }

  
   
   
}
