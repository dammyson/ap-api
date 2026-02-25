<?php

namespace App\Http\Controllers\Soap;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Soap\AddSsrRequest;
use App\Models\Flight;
use App\Services\Soap\AddSsrBuilder;
use App\Services\Soap\BookingBuilder;
use App\Services\Utility\CheckArray;

class AddSsrController extends Controller
{
    protected $addSsrBuilder;
    protected $craneAncillaryOTASoapService;
    protected $craneOTASoapService;
    protected $bookingBuilder;
    protected $checkArray;

    public function __construct(AddSsrBuilder $addSsrBuilder, BookingBuilder $bookingBuilder, CheckArray $checkArray) {
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
        // dd($xml);

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

    private function updateOrCreateInvoice(Invoice $invoice, $amount, $preferredCurrency, $bookingId) {
        $addedPrice = 0;
            // dd($invoice);
           
        if (!$invoice->is_paid) {
            $addedPrice = $invoice->amount - $amount;
            $addedPrice = abs($addedPrice);

            $invoice->update(['amount' => $amount, 'is_paid' => false]);
            
        } else { 
            $invoice = Invoice::create([
                'amount' => $amount,
                'booking_id' => $bookingId,
                'currency' => $preferredCurrency,
                'is_paid' => false
            ]);
            $addedPrice = $amount;
        }


        return [$invoice, $addedPrice];
    }

    

    public function addSsr(AddSsrRequest $request, Invoice $invoice) {        
        $preferredCurrency = $request->input('preferredCurrency');
        $ancillaryRequestList = $request->input('ancillaryRequestList');
        $bookingId = $request->input('bookingReferenceIDID');
        $passengerName = $request->input('passengerName');
        $peaceId = $request->input('peaceId');
        $ssrType = $request->query('ssrType');
        $user = $request->user();
        
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
        // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
          
            $message = "";

            if ($ssrType == "insurance") {
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

                $ticketInfo = data_get($response, 'AddSsrResponse.airBookingList.ticketInfo', []);

                [$amount, $preferredCurrency ] = $this->parseAmountFromResponse($ticketInfo);


                // if user has not paid set the new invoice balance else generate a new invoice
                
                [ $updatedInvoice, $addedPrice ] = $this->updateOrCreateInvoice($invoice, $amount, $preferredCurrency, $bookingId);
            
          
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
                    $flight->amount += $amount;
                    $flight->currency = $preferredCurrency;
                    $flight->is_paid = true;
                    $flight->save();
                }   
                
            
                
            } else if ($ssrType == "baggages") {   

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
                        "message" => $message
                
                    ], 500);
                }

                $ticketInfo = data_get($response, 'AddSsrResponse.airBookingList.ticketInfo', []);

                [$amount, $preferredCurrency ] = $this->parseAmountFromResponse($ticketInfo);


                    // if user has not paid set the new invoice balance else generate a new invoice
                    
                [ $updatedInvoice, $addedPrice ] = $this->updateOrCreateInvoice($invoice, $amount, $preferredCurrency, $bookingId);
                    
                
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
                    $flight->amount += $amount;
                    $flight->currency = $preferredCurrency;
                    $flight->is_paid = true;
                    $flight->save();
                }   
                
                $message = "Baggages added successfully";
            }
      
            return response()->json([
                "error" => false,
                "message" => $message,
                'invoice_id' => $updatedInvoice->id,
                "amount" => $amount
            ], 200);

        } catch (\Throwable $th) {
           
            Log::error($th->getMessage());

            return response()->json([
                'error' => true,
                "message" => "something went wrong",
                "actual_message" => $th->getMessage()
        
            ], 500);
        }
    }

    public function selectSeat(AddSsrRequest $request) {
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
        // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

        $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            // dd($response);

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

    }
    
}
