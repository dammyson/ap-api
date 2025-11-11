<?php

namespace App\Http\Controllers\Soap;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Test\AddSsrRequest;
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

    public function addSsr(AddSsrRequest $request, Invoice $invoice) {        
        $preferredCurrency = $request->input('preferredCurrency');

        $ancillaryRequestList = $request->input('ancillaryRequestList');     
        
        
        $bookingReferenceIDID = $request->input('bookingReferenceIDID');
        $bookingReferenceID = $request->input('bookingReferenceID');
        $passengerName = $request->input('passengerName');
        $peaceId = $request->input('peaceId');

        // dd("i ran");
        $ssrType = $request->query('ssr_type');

        
        $user = $request->user();
        // dd($user->peace_id);
        
        if ($user->is_guest) {

            $function = "http://impl.soap.ws.crane.hititcs.com/ReadBooking";
            $xml = $this->bookingBuilder->readBooking($bookingReferenceIDID, $passengerName);
           // dd($xml);
    
            $response = $this->craneOTASoapService->run($function, $xml);

           // dd($response);
          
            if (!(isset($response['AirBookingResponse']))) {
                return response()->json([
                    "error" => true,
                    "message" => "you are not authorized to carry out this action"
                ], 401);
            }

        } else {
            $booking = Booking::where('booking_id', $bookingReferenceIDID)->where('peace_id', $peaceId)->first();
            if (!$booking) {
                return response()->json([
                    "error" => true,
                    "message" => "you are not authorized to carry out this action"
                ], 401);
            }
        }


        $xml = $this->addSsrBuilder->addSsr(
            $request
        );
        // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            // dd($response);

            $specialServiceRequestList = $response['AddSsrResponse']['airBookingList']["airReservation"]["specialRequestDetails"]["specialServiceRequestList"];
           
            if ($ssrType == "select_seat") {
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

                // foreach ($specialServiceRequestList as $specialServiceRequest) {
                //     if ($specialServiceRequest["SSR"]["code"] == "SEAT") {
                //         return response()->json([
                //                 "error" => false,
                //                 "message" => "Seat Selected Successfully",
                //                 'invoice_id' => $invoice->id,
                //                 "amount" => $invoice->amount
                //         ], 200);
                //     }

                // }

                return response()->json([
                    "error" => false,
                    "message" => "Seat select successfully",
                    'invoice_id' => $invoice->id,
                    "amount" => $invoice->amount
                ], 200);

                

            }

            $ticketInfo = $response["AddSsrResponse"]["airBookingList"]["ticketInfo"];
            $amount = 0;
            $preferredCurrency = null;

            if (array_key_exists('totalAmount', $ticketInfo)) {
                $amount = $ticketInfo["totalAmount"]["value"];
                $preferredCurrency = $response["AddSsrResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["currency"]["code"];

            } else {
                $ticketItemList = $ticketInfo['ticketItemList'];
                if (!$this->checkArray->isAssociativeArray($ticketItemList)) {
                
                    foreach($ticketItemList as $ticketItem) {
                      $preferredCurrency = $preferredCurrency ?? $ticketItem['pricingOverview']['totalAmount']['currency']['code'];
                      $amount += $ticketItem['pricingOverview']['totalAmount']['value'];                        
                    }
                } else  {
                  
                    $preferredCurrency = $ticketItemList['pricingOverview']['totalAmount']['currency']['code'];
                    $amount = $ticketItemList['pricingOverview']['totalAmount']['value'];   
                }
            }

            $bookingId = $response["AddSsrResponse"]["airBookingList"]["airReservation"]["bookingReferenceIDList"]["ID"];


            // if user has not paid set the new invoice balance else generate a new invoice
            
            $addedPrice = 0;
            // dd($invoice);
           
            if (!$invoice->is_paid) {
                $addedPrice = $invoice->amount - $amount;
                $addedPrice = abs($addedPrice);
                $invoice->amount = $amount;
                
            } else { 
                $invoice = Invoice::create([
                    'amount' => $amount,
                    'booking_id' => $bookingId,
                    'currency' => $preferredCurrency
                ]);
                $addedPrice = $amount;
            }
            
          

            // Use preg_match to extract the number
           

            $message = "";

            if ($ssrType == "insurance") {
                $numberOfInsurance = count($ancillaryRequestList);
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product' => 'Insurance', // baggages or ticket shopping
                    'quantity' => $numberOfInsurance,
                    // total_passengers => $totalPassengers  // this field would be removed
                    'price' => $addedPrice
                ]);
                $message = "Insurance added successfully";
                
                // set invoice as false if invoice was added
                $invoice->is_paid = false;
                $invoice->save();
            
            
            } else if ($ssrType == "baggages") {                
                $message = "Something went wrong";

                if (array_key_exists("detail", $response)) {
                    if (array_key_exists("CraneFault", $response["detail"])){
                        if (array_key_exists("code", $response["detail"]["CraneFault"])){
                            if ($response["detail"]["CraneFault"]["code"] == "BAGGAGE_LIMIT_ERROR") {
                                $message = "Requested baggage weight {$response["detail"]["CraneFault"]["args"][0]} exceeds baggage limit {$response["detail"]["CraneFault"]["args"][1]}. Current baggage weight {$response["detail"]["CraneFault"]["args"][2]}";
                            }
                        }
                    }
                    Log::error($th->getMessage());
        
                    return response()->json([
                        'error' => true,
                        "message" => $message
                
                    ], 500);
                }

                foreach ($ancillaryRequestList as $ancillaryRequest) {
                    $ssrExplanation = $ancillaryRequest['ssrExplanation'];
                    preg_match('/\d+/', $ssrExplanation, $matches);
        
                    // $matches[0] will contain the number
                    $quantity = $matches[0];
    
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product' => 'Baggages', // baggages or ticket shopping
                        'quantity' => $quantity,
                        // total_passengers => $totalPassengers  // this field would be removed
                        'price' => $addedPrice
                    ]);
    
                }
                $message = "Baggages added successfully";

                // set invoice as false if baggages was added
                $invoice->is_paid = false;
                $invoice->save();

            }
      
           

            return response()->json([
                "error" => false,
                "message" => $message,
                'invoice_id' => $invoice->id,
                "amount" => $amount
            ], 200);

        } catch (\Throwable $th) {
           
            Log::error($th->getMessage());

            return response()->json([
                'error' => true,
                "message" => $message,
                "actual_message" => $th->getMessage()
        
            ], 500);
        }
    }
}
