<?php

namespace App\Http\Controllers\Soap;

use App\Events\UserActivityLogEvent;
use App\Exceptions\HititException;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Soap\AddSsrRequest;
use App\Models\Flight;
use App\Models\Transaction;
use App\Services\Soap\AddSsrBuilder;
use App\Services\Soap\BookingBuilder;
use App\Services\Utility\CheckArray;
use App\Services\Wallet\FlutterVerificationService;
use App\Services\Wallet\VerificationService;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Services\Payment\Payments;
class AddSsrController extends Controller
{
    protected $addSsrBuilder;
    protected $craneAncillaryOTASoapService;
    protected $craneOTASoapService;
    protected $bookingBuilder;
    protected $checkArray;
    protected $ticketReservationRequestBuilder;    
    protected $payments;    

    public function __construct(Payments $payments, AddSsrBuilder $addSsrBuilder, BookingBuilder $bookingBuilder, CheckArray $checkArray, TicketReservationRequestBuilder $ticketReservationRequestBuilder) {
        $this->payments = $payments;
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->addSsrBuilder = $addSsrBuilder;
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->craneOTASoapService = app("CraneOTASoapService");
        $this->bookingBuilder = $bookingBuilder;
        $this->checkArray = $checkArray;
        
    }

    private function unauthorizedResponse() {
        return response()->json([
            "error" => true,
            "message" => "you are not authorized to carry out this action"
        ], 401);
    }

    private function handleGuestUser($bookingId, $passengerName, $preferredCurrency) {
        $function = "http://impl.soap.ws.crane.hititcs.com/ReadBooking";
        $xml = $this->bookingBuilder->readBooking($bookingId, $passengerName, $preferredCurrency);
      

        return $this->craneOTASoapService->run($function, $xml);
    }

    private function parseAmountFromResponse($ticketInfo) {
        $amount = 0;
        if (array_key_exists('totalAmount', $ticketInfo)) {
            $amount = data_get($ticketInfo, "totalAmount.value");    
            $preferredCurrency = data_get($ticketInfo, 'totalAmount.currency.code');    
          
        } else {
            $ticketItemList = $ticketInfo['ticketItemList'];
            if (!$this->checkArray->isAssociativeArray($ticketItemList)) {
            
                foreach($ticketItemList as $ticketItem) {
                    $preferredCurrency = $preferredCurrency ?? data_get($ticketItem, 'pricingOverview.totalAmount.currency.code');
                    $amount += data_get($ticketItem, 'pricingOverview.totalAmount.value', 0);                    
                }
            } else  {
                  $preferredCurrency = data_get($ticketItemList, 'pricingOverview.totalAmount.currency.code');
                    $amount = data_get($ticketItemList, 'pricingOverview.totalAmount.value', 0);
            }
        }

        return [$amount, $preferredCurrency];

    }

    private function updateOrCreateInvoice($amount, $preferredCurrency, $bookingId, $invoice = null) {
        $addedPrice = 0;
           
        if ($invoice && !$invoice->is_paid && $invoice->type == "ssr") {
            $addedPrice = $invoice->amount - $amount;
            $addedPrice = abs($addedPrice);

            $invoice->update(['amount' => $amount, 'is_paid' => false]);
            
        } else { 
            $invoice = Invoice::create([
                'amount' => $amount,
                'booking_id' => $bookingId,
                "type" => "ssr",
                'currency' => $preferredCurrency,
                'is_paid' => false
            ]);
            $addedPrice = $amount;
        }


        return [$invoice, $addedPrice];
    }

    

    public function addInsuranceSsr(AddSsrRequest $request, ) {

        $preferredCurrency = $request->input('preferredCurrency');
        $ancillaryRequestList = $request->input('ancillaryRequestList');
        $passengerName = $request->input('passengerName');
        $peaceId = $request->input('peaceId');
        $ssrType = $request->query('ssrType');
        $ref = $request->input('ref');
        $paymentMethod = $request->input('payment_method');
        $paymentChannel = $request->input('payment_channel');
        $preferredCurrency = $request->input('preferred_currency');
        $deviceType = $request->input('device_type');
        $bookingId = $request->input('bookingReferenceIDID');
        $bookingReferenceId = $request->input('bookingReferenceID');
        $invoiceId = $request->input('invoiceId');

        try {

            $user = $request->user();

            $request->validate([
                "ref" => "required|string",
                "payment_method" => "required|string",
                "payment_channel" => "required|string",
                "device_type" => "required|string"
            ]);
            
        
            if ($user->is_guest) {

                
                $response = $this->handleGuestUser($bookingId, $passengerName, $preferredCurrency);

                if (!(isset($response['AirBookingResponse']))) {
                    return $this->unauthorizedResponse();
                }

                // $bookingReferenceId = data_get($response, 'AirBookingResponse.airBookingList.bookingReferenceIDList.referenceID', '');

            } else {
                $booking = Booking::where('booking_id', $bookingId)->where('peace_id', $peaceId)->first();
            
            
                // $bookingReferenceId = $booking->booking_reference_id;
                if (!$booking) {
                return $this->unauthorizedResponse();
                }
            }

       

            $xml = $this->addSsrBuilder->addSsr(
                $request
            );

            // validate verifiedRequest;
            if ($paymentChannel == "paystack") {
                $new_top_request = new VerificationService($ref);

            } else if ($paymentChannel == "flutterwave") {
                $new_top_request = new FlutterVerificationService($ref);

            }

            $verified_request = $new_top_request->run();
      
            $paidAmount = $verified_request["data"]["amount"];
            $paidCurrency = $verified_request['data']['currency'];
            
            // convert to naira (from kobo)

            if ($paymentChannel == "paystack") {
                $paidAmount = $paidAmount / 100;
            
            } else if ($paymentChannel == "flutterwave") {
                $paidAmount = $paidAmount;
            
            }


            $payment = $this->payments->createPayment([
                'user_id' => $user->id,
                'ref' => $ref,
                'amount' => $paidAmount,
                'currency' => $paidCurrency,
                'channel' => $paymentChannel,
                'method' => $paymentMethod,
                'purpose' => "Insurance",
                'payment_status' => 'completed',
                'booking_api_status' => 'processing',
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceId,
            ]);


            $paidAmount = (float) $paidAmount;

            $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
           
            $message = "";

            $ticketInfo = data_get($response, 'AddSsrResponse.airBookingList.ticketInfo', []);

            [$expectedAmount, $preferredCurrency ] = $this->parseAmountFromResponse($ticketInfo);

            if (  $paidAmount != $expectedAmount) {
                return response()->json([
                    "error" => true,
                    "message" => "Amount mismatch, expected amount is {$expectedAmount} but paid amount is {$paidAmount}",
                    "amount_paid" => $paidAmount,
                    "amount_expected" => $expectedAmount
                ], 400);
            }

            if (array_key_exists("detail", $response)) {
                if (array_key_exists("CraneFault", $response["detail"])){
                    if (array_key_exists("code", $response["detail"]["CraneFault"])){
                        if ($response["detail"]["CraneFault"]["code"] == "CHECK_PAX_SSR_COUNT") {
                        
                            return response()->json([
                                "error" => true,            
                                "message" => "Passenger already has an insurance added"
                            ], 400);
                        
                        }
                    }  
                } 
            }
            
         
            
             // get the latest ssr invoice 
            $invoice = Invoice::where('booking_id', $bookingId)
                ->where('type', 'ssr')
                ->latest()
                ->first();
            
            $payment->update([
                'invoice_id' => $invoice ? $invoice->id : null
            ]);

            [ $updatedInvoice, $addedPrice ] = $this->updateOrCreateInvoice($expectedAmount, $preferredCurrency, $bookingId, $invoice);
        
            $updatedInvoice->is_paid = true;
            $updatedInvoice->save();

            $numberOfInsurance = count($ancillaryRequestList);
            InvoiceItem::create([
                'invoice_id' => $updatedInvoice->id,
                'product' => 'Insurance', // baggages or ticket shopping
                'quantity' => $numberOfInsurance,
                // total_passengers => $totalPassengers  // this field would be removed
                'price' => $addedPrice
            ]);
            $message = "Insurance added successfully";

            $flights = Flight::where('booking_id', $bookingId)->get();

            foreach ($flights as $flight) {
                $flight->amount += $expectedAmount;
                $flight->currency = $preferredCurrency;
                $flight->is_paid = true;
                $flight->save();
            }   
   
            // commit the ssr
            $this->handleTicketingSsr($preferredCurrency, $bookingId, $bookingReferenceId, $ssrType, $expectedAmount, $deviceType, $paymentMethod, $paymentChannel, $updatedInvoice->id);
      
            return response()->json([
                "error" => false,
                "message" => $message,
                'invoice_id' => $updatedInvoice->id,
                "amount" => $expectedAmount
            ], 200);

        } catch (HititException $e) {
            
                Log::error('HITIT ERROR ADDING INSURANCE', [
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
            
            Log::error('ERROR ADDING INSURANCE', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            if ($th->getMessage() == "Payment verification failed" || $th->getMessage() == "Payment already processed") {
                 if ($th->getMessage() == "Payment verification failed") {
                    $payment = $this->payments->createPayment([
                        'user_id' => $user->id,
                        'ref' => $ref,
                        'amount' => $paidAmount,
                        'currency' => $paidCurrency,
                        'channel' => $paymentChannel,
                        'method' => $paymentMethod,
                        'purpose' => $purpose ?? 'flight booking|baggages',
                        'payment_status' => 'failed',
                        'booking_api_status' => 'processing',
                        'booking_id' => $bookingId,
                        'booking_reference_id' => $bookingReferenceId,
                        'invoice_id' => $invoiceId,
                    ]);
                }

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

    public function addBaggagesSsr(AddSsrRequest $request) {

        $preferredCurrency = $request->input('preferredCurrency');
        $ancillaryRequestList = $request->input('ancillaryRequestList');
        $bookingId = $request->input('bookingReferenceIDID');
        $passengerName = $request->input('passengerName');
        $peaceId = $request->input('peaceId');
        $user = $request->user();
        $preferredCurrency = $request->input('preferred_currency');       
        

        try {

            if ($user->is_guest) {

                
                $response = $this->handleGuestUser($bookingId, $passengerName, $preferredCurrency);

                if (!(isset($response['AirBookingResponse']))) {
                    return $this->unauthorizedResponse();
                }

            } else {
                $booking = Booking::where('booking_id', $bookingId)->where('peace_id', $peaceId)->first();
                
                if (!$booking) {
                    return $this->unauthorizedResponse();
                }
            }

            $xml = $this->addSsrBuilder->addSsr(
                $request
            );

            $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            
            if (array_key_exists("detail", $response)) {
                if (array_key_exists("CraneFault", $response["detail"])){
                    if (array_key_exists("code", $response["detail"]["CraneFault"])){
                        if ($response["detail"]["CraneFault"]["code"] == "BAGGAGE_LIMIT_ERROR") {
                            $message = "Requested baggage weight {$response["detail"]["CraneFault"]["args"][0]} exceeds baggage limit {$response["detail"]["CraneFault"]["args"][1]}. Current baggage weight {$response["detail"]["CraneFault"]["args"][2]}";
                        }
                    }
                }        
                return response()->json([
                    'error' => true,
                    "message" => $message ?? "unable to add baggages for this flight"

            
                ], 500);
            }

            $ticketInfo = data_get($response, 'AddSsrResponse.airBookingList.ticketInfo', []);

            [$expectedAmount, $preferredCurrency ] = $this->parseAmountFromResponse($ticketInfo);

            // if user has not paid set the new invoice balance else generate a new invoice
            
            // get the latest ssr invoice 
            $invoice = Invoice::where('booking_id', $bookingId)
                ->where('type', 'ssr')
                ->latest()
                ->first();

            // invoice is generated if no exist or updated if it's existing but unpaid
            [ $updatedInvoice, $addedPrice ] = $this->updateOrCreateInvoice($expectedAmount, $preferredCurrency, $bookingId, $invoice);
                
            
            foreach ($ancillaryRequestList as $ancillaryRequest) {
                $ssrExplanation = $ancillaryRequest['ssrExplanation'];
                preg_match('/\d+/', $ssrExplanation, $matches);
    
                // $matches[0] will contain the number
                $quantity = $matches[0];

                InvoiceItem::create([
                    'invoice_id' => $updatedInvoice->id,
                    'product' => 'Baggages', // baggages or ticket shopping
                    'quantity' => $quantity,
                    // total_passengers => $totalPassengers  // this field would be removed
                    'price' => $addedPrice
                ]);

            }
            $flights = Flight::where('booking_id', $bookingId)->get();

            foreach ($flights as $flight) {
                $flight->amount += $expectedAmount;
                $flight->currency = $preferredCurrency;
                $flight->is_paid = false;
                $flight->save();
           
            }             
           
            return response()->json([
                "error" => false,
                "message" => "Baggages added successfully",
                'invoice_id' => $updatedInvoice->id,
                "amount" => $expectedAmount
            ], 200);

        } catch (HititException $e) {
            
            Log::error('HITIT ERROR ADDING BAGGAGES', [
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

            Log::error('ERROR ADDING BAGGAGES', [
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

    private function handleTicketingSsr($preferredCurrency, $bookingId, $bookingReferenceId, $ssr, $amount, $deviceType, $paymentMethod, $paymentChannel, $invoiceId) {
        $xml = $this->ticketReservationRequestBuilder->ticketReservationCommit(
            $preferredCurrency,           
            $bookingId,
            $bookingReferenceId,           
            $amount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
          
        );


        try {
           
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);


            if (!array_key_exists('AirTicketReservationResponse', $response)) {
                return response()->json([
                    'error' => true,
                    'message' => "no new addition to ticket",
                    'paidAmount' => $amount,
                ], 500);
            }        

            // get the list of all the tickets 
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];
          
            // Device::where('user_id', $user->id)->first();        

            $user = auth()->user();
            // $deviceType = $user ? $user->device_type : $deviceType;
           

            if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                $ticketItemList = [$ticketItemList];
            }

            foreach($ticketItemList as $ticketItem) {

                $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                
                if (!array_key_exists('asvcSsr', $ticketItem['couponInfoList'])) {
         
                    
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                            
                    ], [
                        'amount' => $amount,
                        'booking_id' => $bookingId,
                        'transaction_type' => $transactionType,
                        'booking_id' => $bookingId,
                        'ticket_type' => 'ticket',
                        'user_id' =>  $user->id,
                        'invoice_id' => $invoiceId,
                        'device_type' => $deviceType,
                        'is_flight' => true,                             
                        "payment_method" => $paymentMethod ?? "not applicable",
                        "payment_channel" => $paymentChannel ?? "not applicable",
                        'currency' => $preferredCurrency

                    ]); 
                                          
                
                }
                else {      
                                                
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                            
                    ], [
                        'amount' => $amount,
                        'booking_id' => $bookingId,
                        'transaction_type' => $transactionType,
                        'ticket_type' => 'Ancillary',
                        'user_id' => $user->id,
                        'invoice_id' => $invoiceId,
                        'device_type' => $deviceType,
                        'is_flight' => true,
                        "payment_method" => $paymentMethod ?? "not applicable",
                        "payment_channel" => $paymentChannel ?? "not applicable",
                        'currency' => $preferredCurrency

                    ]); 

                }                
            }
        

            $description = "made for a payment of {$amount} for {$ssr} for flight with booking id {$bookingId}";
            event(new UserActivityLogEvent($user, "{$ssr} Payment", $description));

           
         
        } catch (\Throwable $th) {

            Log::error($th);
            throw $th;
            // throw new \Exception("adding Ssr failed Pls contact Support");
           
        }  
    }

    public function selectSeat(AddSsrRequest $request) {

        try {
            
            $bookingId = $request->input('bookingReferenceIDID');
            $passengerName = $request->input('passengerName');
            $peaceId = $request->input('peaceId');
            $user = $request->user();
            
            if ($user->is_guest) {            
                $response = $this->handleGuestUser($bookingId, $passengerName, "NGN");

                if (!(isset($response['AirBookingResponse']))) {
                    return $this->unauthorizedResponse();
                }

            } else {
                $booking = Booking::where('booking_id', $bookingId)->where('peace_id', $peaceId)->first();
                if (!$booking) {
                return $this->unauthorizedResponse();
                }
            }


            $xml = $this->addSsrBuilder->addSsr(
                $request
            );
           

            $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

            $response = $this->craneAncillaryOTASoapService->run($function, $xml);

            if (array_key_exists("detail", $response)) {
                if (array_key_exists("CraneFault", $response["detail"])){
                    if (array_key_exists("code", $response["detail"]["CraneFault"])){
                        if ($response["detail"]["CraneFault"]["code"] == "ASR_ADDING_SEAT_NOT_ALLOWED") {
                            $message = "You are not allowed to add more seat for this passenger";
                            return response()->json([
                                "error" => true,            
                                "message" => $message
                            ], 400);
                        
                        }
                    }
                }

                return response()->json([
                    "error" => true,            
                    "message" => "unable to select seat"
                ], 400);
            }
                    
            

            return response()->json([
                "error" => false,
                "message" => "Seat select successfully"
            
            ], 200);
        } catch (HititException $e) {
            
            Log::error('HITIT ERROR SELECTING SEAT', [
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

            Log::error('ERROR SELECTING SEAT', [
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
