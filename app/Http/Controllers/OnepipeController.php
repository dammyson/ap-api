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
        $secret = env('ONE_PIPE_SECRET');
        $signature = md5("{$requestRef};{$secret}");
        $user = $request->user();
        $bookingId = $request['booking_id'];
        $transactionRef =  $this->generateRandom->generateRandomNumber();
       
        $response = Http::withHeaders([
            'Authorization' =>  'Bearer ' . env('ONE_PIPE_BEARER_API_KEY'), // move this to env once test is complete
            'Signature' => $signature, // md5 hash of ref;secret
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post(env('ONE_PIPE_TRANSACT_URL'), [
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
                    "pnr"=> $bookingId,
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

            $booking = Booking::where('booking_id', $bookingId)->first();
                
            if (!$booking) {
                return response()->json([
                    "error" => true,
                    "message" => "please ensure bookingId is correct"
                ], 400);
            }

            $booking->request_ref = $requestRef;
            $booking->save();
            // Booking::create([
            //     'booking_id' => $pnr,
            //     'request_ref' => $request_ref
            // ]);


        // dd($response->body());
        
      
        return response()->json([
            "error" => false,
            "data" => $response->body(),
            'booking_id' => $bookingId,
            "request_ref" => $requestRef,
            "transaction_ref" => $transactionRef,
            'response' => $response
        ], $response->status());
     
    }

    public function queryPaymentStatus(Request $request) {
        $bankName = $request['bank_name'];

        $secret = env('ONE_PIPE_SECRET');
        // $secret = env('ONEPIPE_SECRET');
        $requestRef = $request->input('request_ref');
        $bookingId = $request->input('booking_id');
        $signature = md5("{$request->input('request_ref')};{$secret}");

        $booking = Booking::where('request_ref', $requestRef)
            ->where('booking_id', $bookingId)->first();

        if(!$booking) {
            return response()->json([
                "error" => true,
                "message" => "request ref does not match record"
            ], 400);
        }


        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('ONE_PIPE_BEARER_API_KEY'), // move this to env once test is complete
            'Signature' => $signature, // md5 hash of ref;secret
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->post(env('ONE_PIPE_TRANSACT_QUERY_URL'), [
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
        
        // dd($response->json()); 
        // return $response;
     
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
        $pnr = $response["data"]["provider_response"]["meta"]["pnr"];
        $amount = $response["data"]["provider_response"]["meta"]["booking_amount"];
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

    public function verifyQuickTeller(Request $request) {
        $merchantCode = $request->input('merchant_code');
        $transactionReference = $request->input('transaction_reference');
        $amount = $request->input('amount');
        $bookingId = $request->input('booking_id');
        $deviceType = $request->input('device_type');

        $booking = Booking::where('booking_id', $bookingId)->first();

        if(!$booking) {
            return response()->json([
                "error" => true,
                "message" => "request ref does not match record"
            ], 400);
        }


        //convert amount to kobo
        $amount = $amount * 100;

        $bearer = "Bearer eyJhbGciOiJSUzI1NiJ9.eyJtZXJjaGFudF9jb2RlIjoiTVg2MDcyIiwicmVxdWVzdG9yX2lkIjoiMTIzODA4NTk1MDMiLCJpbmNvZ25pdG9fcmVxdWVzdG9yX2lkIjoiMTIzODA4NTk1MDMiLCJwYXlhYmxlX2lkIjoiMzM1OTciLCJjbGllbnRfZGVzY3JpcHRpb24iOm51bGwsImNsaWVudF9pZCI6IklLSUFCMjNBNEUyNzU2NjA1QzFBQkMzM0NFM0MyODdFMjcyNjdGNjYwRDYxIiwiYXVkIjpbImFwaS1nYXRld2F5IiwiYXJiaXRlciIsImNhZXNhciIsImhpbXMtcG9ydGxldCIsImltdG8tb3JkZXItc2VydmljZSIsImltdG8tc2VydmljZSIsImltdG8tdHJhbnNhY3Rpb24tc2VydmljZSIsImluY29nbml0byIsImlzdy1jb2xsZWN0aW9ucyIsImlzdy1jb3JlIiwiaXN3LWluc3RpdHV0aW9uIiwiaXN3LWxlbmRpbmctc2VydmljZSIsImlzdy1wYXBlIiwiaXN3LXBhcHJzIiwiaXN3LXBhcHNzIiwiaXN3LXBheW1lbnRnYXRld2F5IiwiaXN3LXBvc3Qtb2ZmaWNlIiwia3ljLXNlcnZpY2UiLCJtZXJjaGFudC13YWxsZXQiLCJwYXNzcG9ydCIsInBheW1hdGUtd2FsbGV0LXNlcnZpY2UiLCJwb3N0aWxpb24tYXBpIiwicHJvamVjdC14LWNvbnN1bWVyIiwicHJvamVjdC14LW1lcmNoYW50IiwicXQtc2VydmljZSIsInF1aWNrdGVsbGVyLWV0bHItcmVxdWVyeSIsInJlY3VycmVudC1iaWxsaW5nLWFwaSIsInRyYW5zZmVyLXNlcnZpY2UtYWRtaW4iLCJ0cmFuc2Zlci1zZXJ2aWNlLWNvcmUiLCJ2YXVsdCIsInZlcnZlLXB1c2gtc2VydmljZSIsInZvdWNoZXItYXBpIiwid2FsbGV0Iiwid2VicGF5LXBvcnRsZXQiXSwiY2xpZW50X2F1dGhvcml6YXRpb25fZG9tYWluIjoiTVg2MDcyIiwic2NvcGUiOlsiY2xpZW50cyIsInByb2ZpbGUiXSwiYXBpX3Jlc291cmNlcyI6WyJyaWQtUE9TVC9hcGkvdjEvcHVyY2hhc2VzIiwicmlkLVBPU1QvYXBpL3YxL3B1cmNoYXNlcy8qKiIsInJpZC1QVVQvYXBpL3YxL3B1cmNoYXNlcyIsInJpZC1QVVQvYXBpL3YxL3B1cmNoYXNlcy8qKiIsInJpZC1HRVQvYXBpL3YxL3B1cmNoYXNlcyIsInJpZC1HRVQvYXBpL3YxL3B1cmNoYXNlcy8qKiIsInJpZC1ERUxFVEUvYXBpL3YxL3B1cmNoYXNlcyIsInJpZC1ERUxFVEUvYXBpL3YxL3B1cmNoYXNlcy8qKiIsInJpZC1QT1NUL2FwaS92Mi9wdXJjaGFzZXMiLCJyaWQtUE9TVC9hcGkvdjIvcHVyY2hhc2VzLyoqIiwicmlkLVBVVC9hcGkvdjIvcHVyY2hhc2VzIiwicmlkLVBVVC9hcGkvdjIvcHVyY2hhc2VzLyoqIiwicmlkLUdFVC9hcGkvdjIvcHVyY2hhc2VzIiwicmlkLUdFVC9hcGkvdjIvcHVyY2hhc2VzLyoqIiwicmlkLURFTEVURS9hcGkvdjIvcHVyY2hhc2VzIiwicmlkLURFTEVURS9hcGkvdjIvcHVyY2hhc2VzLyoqIiwicmlkLVBPU1QvYXBpL3YzL3B1cmNoYXNlcyIsInJpZC1QT1NUL2FwaS92My9wdXJjaGFzZXMvKioiLCJyaWQtUFVUL2FwaS92My9wdXJjaGFzZXMiLCJyaWQtUFVUL2FwaS92My9wdXJjaGFzZXMvKioiLCJyaWQtR0VUL2FwaS92My9wdXJjaGFzZXMiLCJyaWQtR0VUL2FwaS92My9wdXJjaGFzZXMvKioiLCJyaWQtREVMRVRFL2FwaS92My9wdXJjaGFzZXMiLCJyaWQtREVMRVRFL2FwaS92My9wdXJjaGFzZXMvKioiXSwibWVyY2hhbnQtd2FsbGV0LWFjdGlvbnMiOlsic2V0dGxlIiwidHJhbnNhY3QiLCJyZXZlcnNlIl0sImV4cCI6MTc0NDI3MTU2MywiY2xpZW50X25hbWUiOiJSN2pKaHJFZ3lMIiwiY2xpZW50X2xvZ28iOm51bGwsImp0aSI6IjlkOWNiMmM4LWEyZjUtNGExNS04YjcwLWU1ZTg4ZGNkNjc0NyJ9.ew4118y40IFwcqS8sDwVPSyactMEhk95QXA8XBi1avXDdxLS5nSRG3EKk3fpRZW9HKfWmsSwjElgtJ991OMG-79cFfdsK59RVSVW6Q8FQN26Rj-bETJjlneIEFx8E0HP0du9DDtRGibENI-Ag_e_UnOzkHcKGxmsfil7hbF1OHeXUBeZ0OVj9CAYJNWoxr6w_LzF0dhHPsq_hJmAtrtWqPlNvzMEtaDzNlnMk3D8M7ZY9kA1GeyxqNxpW1RTKBz1kfSA860gJgPZG5_hofpMowBh--3Vp2ofINnD9z2y3L11hqgjjmQEa3Jq8V8A90vVUohWufBeBpc-jiVvRA4_2w";
        $response = Http::withHeaders([
            // 'Authorization' => 'Bearer ' . env('ONE_PIPE_BEARER_API_KEY'), // move this to env once test is complete
            'Authorization' => $bearer, // move this to env once test is complete
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->get("https://qa.interswitchng.com/collections/api/v1/gettransaction?merchantcode=MX6072&transactionreference={$transactionReference}&amount={$amount}");
          
       
        // dd($response->body());
        $responseCode = $response["ResponseCode"];
        // dd($responseCode);

        // if ($responseCode == "S0" ) {
        //     $currency = "NGN";
        //     $pnr = $booking->booking_id;
        //     $amount = $response['amount'];
        // }

        // if ($responseCode == "T0" ) {
        //     $currency = "NGN";
        //     $pnr = $booking->booking_id;
        //     $amount = $response['amount'];
        // }

        if ($responseCode == "00" ) {
            $currency = "NGN";
            $pnr = $booking->booking_id;
            // $amount = $response['Amount'];
            // $amount = $response['Amount'];
            $deviceType = $request['device_type'];
    
            // convert to naira (from kobo)
            $amount = $amount / 100;
    
            // dd(["currecny" => $currency, "pnr" => $pnr, "amount" => $amount, "bookingReference" => $booking->booking_reference_id, "invoice_id" => $booking->invoice_id, "deviceType" => $deviceType]);
                                
            return  $this->ticketReservationController->guestTicketReservationCommit("bank transfer", "Quick teller" , $currency, $pnr, $booking->booking_reference_id, $amount, $booking->invoice_id, $deviceType);
        
        }

        $currency = $response["data"]["provider_response"]["meta"]["account"]["currency_code"];
        $pnr = $response["data"]["provider_response"]["meta"]["pnr"];
        $amount = $response["data"]["provider_response"]["meta"]["booking_amount"];
        $deviceType = $request['device_type'];

        // convert to naira (from kobo)
        $amount = $amount / 100;

        // dd(["currency" => $currency, "pnr" => $pnr, "amount" => $amount, "bookingReference" => $booking->booking_reference_id, "invoice_id" => $booking->invoice_id, "deviceType" => $deviceType]);
                            
        return  $this->ticketReservationController->guestTicketReservationCommit("bank transfer", "Quick teller" , $currency, $pnr, $booking->booking_reference_id, $amount, $booking->invoice_id, $deviceType);
    }

  
   
   
}
