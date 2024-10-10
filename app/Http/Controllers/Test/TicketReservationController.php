<?php

namespace App\Http\Controllers\Test;

use App\Models\Wallet;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\InvoiceRecord;
use App\Models\TransactionType;
use App\Models\TransactionRecord;
use App\Http\Controllers\Controller;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Requests\Test\Ticket\TicketReservationCommitRequest;
use App\Http\Requests\Ticket\TicketReservationViewOnlyTwoARequest;
use App\Http\Requests\Test\Ticket\TicketReservationCommitRTRequest;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRequest;
use App\Http\Requests\Test\Ticket\TicketReservationCommitTwoARequest;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRTRequest;

class TicketReservationController extends Controller
{

    protected $ticketReservationRequestBuilder;    
    protected $craneOTASoapService;

    public function __construct(TicketReservationRequestBuilder $ticketReservationRequestBuilder)
    {
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
    }

    public function ticketReservationViewOnlyRT(TicketReservationViewOnlyRTRequest $request) {
        $companyNameCityCode = $request->input('companyNameCityCode');
        $companyNameCode = $request->input('companyNameCityCode');
        $companyNameCodeContext = $request->input('companyNameCodeContext');
        $companyFullName = $request->input('companyNameCodeContext');
        $companyShortName = $request->input('companyShortName');
        $companyCountryCode = $request->input('companyShortName');
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $requestPurpose = $request->input('requestPurpose');
 
     
        $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnlyRT(
            $companyNameCityCode,
            $companyNameCode,
            $companyNameCodeContext,
            $companyFullName,
            $companyShortName,
            $companyCountryCode,
            $ID,
            $referenceID,
            $requestPurpose
        );
         

        try {
            
            dd($xml);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function ticketReservationViewOnly(TicketReservationViewOnlyRequest $request) {
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');

        // $function = 'http://impl.soap.ws.crane.hititcs.com/ticketReservationViewOnlyRT';

        $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
            $ID,
            $referenceID
        );

        try {
          
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
            dd($response);
           
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    public function ticketReservationCommitRT(TicketReservationCommitRTRequest $request) {
        $companyNameCityCode = $request->input('companyNameCityCode');
        $companyNameCode = $request->input('companyNameCode');
        $companyNameCodeContext = $request->input('companyNameCodeContext');
        $companyFullName = $request->input('companyFullName');
        $companyShortName = $request->input('companyFullName');
        $countryCode = $request->input('countryCode');
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $capturePaymentToolNumber = $request->input('capturePaymentToolNumber');
        $paymentCode = $request->input('paymentCode');
        $threeDomainSecurityEligible = $request->input('threeDomainSecurityEligible');
        $MCONumber = $request->input('MCONumber');
        $paymentAmountCurrencyCode = $request->input('paymentAmountCurrencyCode');
        $paymentAmountValue = $request->input('paymentAmountValue');
        $paymentType = $request->input('paymentType');
        $primaryPayment = $request->input('primaryPayment');
        $requestPurpose = $request->input('requestPurpose');


        $xml = $this->ticketReservationRequestBuilder->ticketReservationCommitRT(
            $companyNameCityCode,
            $companyNameCode,
            $companyNameCodeContext,
            $companyFullName,
            $companyShortName,
            $countryCode,
            $ID,
            $referenceID,
            $capturePaymentToolNumber,
            $paymentCode,
            $threeDomainSecurityEligible,
            $MCONumber,
            $paymentAmountCurrencyCode,
            $paymentAmountValue,
            $paymentType,
            $primaryPayment,
            $requestPurpose
        );

        try {
            dd($xml);
           
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    public function ticketReservationCommit($bookingId, $bookingReferenceId, $amount, $invoiceId) {
        $invoice = InvoiceRecord::find($invoiceId);

        if (!$invoice) {
            return response()->json([
                "error" => true,
                "message" => "No record of invoice"
            ], 404);
        } 

       

        if ($invoice->is_paid) {
            // dd("Invoice already Paid for");
            return response()->json([
                "error" =>  true,
                "message" => "Invoice already paid for"
            ], 500);
        }

        if ( $amount < $invoice->amount ) {
            return response()->json([
                "error" => false,
                "message" => "fund payment for ticket is less than calculated"
            ], 500);
        }

        $xml = $this->ticketReservationRequestBuilder->ticketReservationCommit(           
            $bookingId,
            $bookingReferenceId,           
            $amount,
          
        );


        try {
            
            $user = auth()->user();
            $peaceId = $user->peace_id;          

            
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
            
            // dd($response);
            $invoice->is_paid = true;
            $invoice->save();
           
            if (!array_key_exists('AirTicketReservationResponse', $response)) {
                return response()->json([
                    'error' => true,
                    'message' => "no new addition to ticket"
                ], 500);
            }        

            // get the list of all the tickets 
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];
            $flightNumber = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['flightNumber'];
            
            

            if (array_key_exists('couponInfoList', $ticketItemList)) {
                $paymentReferenceID = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                    $invoice_number = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                    $paymentType = $ticketItemList['paymentDetails']['paymentDetailList']['paymentType'];
                    $amount = $ticketItemList['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                    $orderID = $ticketItemList['paymentDetails']['paymentDetailList']['orderID'];
                    $ticketId = $ticketItemList['ticketDocumentNbr'];
                
                if (!array_key_exists('asvcSsr', $ticketItemList['couponInfoList'])) {                    
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']; // meant to be an array but an empty string when nothing is found;
                     
                    TransactionRecord::firstOrCreate([
                        "invoice_number" => $invoice_number
                    ], [
                        'transaction_type' => $transactionType,
                        'peace_id' => $peaceId,
                        'amount' => $amount,
                        'ticket_type' => 'ticket',
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id
                    ]);                    
                
                }

                else { 
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                           
                    TransactionRecord::firstOrCreate([
                        "invoice_number" => $invoice_number
                        ],
                        [
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'amount' => $amount,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id
                        ]
                    ); 
                    
                } 
            
            
            } else {
                foreach($ticketItemList as $ticketItem) {
                    // if ($ticketItem["status"] == "OK") {
                        // dump($user->first_name);
                    $paymentReferenceID = $ticketItem['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                    $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                    $paymentType = $ticketItem['paymentDetails']['paymentDetailList']['paymentType'];
                    $amount = $ticketItem['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                    $orderID = $ticketItem['paymentDetails']['paymentDetailList']['orderID'];
                    $ticketId = $ticketItem['ticketDocumentNbr'];

                    if (!array_key_exists('asvcSsr', $ticketItem['couponInfoList'])) {
                        // dump('non asvcSsr ran');
                       
                        $reasonForIssuance = $ticketItem['reasonForIssuance']; // meant to be an array but an empty string when nothing is found;
                        
                          
                        TransactionRecord::firstOrCreate([
                            "invoice_number" => $invoice_number
                        ], [
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'amount' => $amount,
                            'ticket_type' => 'ticket',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id
                        ]);  

                        
                    
                    }
                    else {      
                        $reasonForIssuance = $ticketItem['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                                    
                        TransactionRecord::firstOrCreate([
                            "invoice_number" => $invoice_number
                        ], [
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'amount' => $amount,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id
                        ]); 
                    }                
                }
            }
            

            dd("transaction successfully recorded");

            return response()->json([
                "error" => false,
                "message" => "transaction successfully recorded"
            ], 200);           
            // }   
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    public function  ticktReservationCommitTwoA (TicketReservationCommitTwoARequest $request) {
        $companyNameCitycode = $request->input('companyNameCitycode');
        $companyNameCode = $request->input('companyNameCode');
        $companyNameCodeContext = $request->input('companyNameCodeContext');
        $companyFullName = $request->input('companyFullName');
        $companyShortName = $request->input('companyShortName');
        $countryCode = $request->input('countryCode');
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $capturePaymentToolNumber = $request->input('capturePaymentToolNumber');
        $paymentCode = $request->input('paymentCode');
        $threeDomainSecurityEligible = $request->input('threeDomainSecurityEligible');
        $MCONumber = $request->input('MCONumber');
        $paymentAmountCurrencyCode = $request->input('paymentAmountCurrencyCode');
        $paymentAmountValue = $request->input('paymentAmountValue');
        $paymentType = $request->input('paymentType');
        $primaryPayment = $request->input('primaryPayment');
        $requestPurpose = $request->input('requestPurpose');


        $xml = $this->ticketReservationRequestBuilder->TicketReservationCommitTwoA(
            $companyNameCitycode,
            $companyNameCode,
            $companyNameCodeContext,
            $companyFullName,
            $companyShortName,
            $countryCode,
            $ID,
            $referenceID,
            $capturePaymentToolNumber,
            $paymentCode,
            $threeDomainSecurityEligible,
            $MCONumber,
            $paymentAmountCurrencyCode,
            $paymentAmountValue,
            $paymentType,
            $primaryPayment,
            $requestPurpose
        );

        try {
            dd($xml);
           
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }  

    } 

    public function ticketReservationViewOnlyTwoA (TicketReservationViewOnlyTwoARequest $request) {
        $cityCode = $request->input('cityCode');
        $code = $request->input('code');
        $codeContext = $request->input('codeContext');
        $companyFullName = $request->input('companyFullName');
        $companyShortName = $request->input('companyShortName');
        $countryCode = $request->input('countryCode');
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $requestPurpose = $request->input('requestPurpose');

        $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnlyTwoA(
            $cityCode,
            $code,
            $codeContext,
            $companyFullName,
            $companyShortName,
            $countryCode,
            $ID,
            $referenceID,
            $requestPurpose   
        );

        try {
          
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
            dd($response);
           
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
}
