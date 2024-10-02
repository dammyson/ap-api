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
        $companyNameCityCode = $request->input('companyNameCityCode');
        $companyNameCode = $request->input('companyNameCode');
        $companyNameCodeContext = $request->input('companyNameCodeContext');
        $companyFullName = $request->input('companyFullName');
        $companyShortName = $request->input('companyShortName');
        $companyNameCountryCode = $request->input('companyNameCountryCode');
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $requestPurpose = $request->input('requestPurpose');

        // $function = 'http://impl.soap.ws.crane.hititcs.com/ticketReservationViewOnlyRT';

        $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
            $companyNameCityCode,
            $companyNameCode,
            $companyNameCodeContext,
            $companyFullName,
            $companyShortName,
            $companyNameCountryCode,
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

    public function ticketReservationCommit(TicketReservationCommitRequest $request) {
        $companyNameCityCode = $request->input('companyNameCityCode');
        $companyNameCode = $request->input('companyNameCode');
        $companyNameCodeContext = $request->input('companyNameCodeContext');
        $companyFullName = $request->input('companyFullName');
        $companyShortName = $request->input('companyShortName');
        $companyNameCountryCode = $request->input('companyNameCountryCode');
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $capturePaymentToolNumber = $request->input('capturePaymentToolNumber');
        $paymentCode = $request->input('paymentCode');
        $threeDomainSecurityEligible = $request->input('threeDomainSecurityEligible');
        $MCONumber = $request->input('MCONumber');
        $code = $request->input('code');
        $value = $request->input('value');
        $paymentType = $request->input('paymentType');
        $primaryPayment = $request->input('primaryPayment');
        $requestPurpose = $request->input('requestPurpose');

        $xml = $this->ticketReservationRequestBuilder->ticketReservationCommit(
            $companyNameCityCode,
            $companyNameCode,
            $companyNameCodeContext,
            $companyFullName,
            $companyShortName,
            $companyNameCountryCode,
            $ID,
            $referenceID,
            $capturePaymentToolNumber,
            $paymentCode,
            $threeDomainSecurityEligible,
            $MCONumber,
            $code,
            $value,
            $paymentType,
            $primaryPayment,
            $requestPurpose
        );


        try {
            
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
            
            // dd($response);
           
            if (!array_key_exists('AirTicketReservationResponse', $response)) {
                return response()->json([
                    'error' => true,
                    'message' => "no new addition to ticket"
                ], 500);
            }
            $user = $request->user();
            $peaceId = $user->peace_id;

            //later on check if an array or object is returned so you can handle the reponse correctly;
            $leadPassengerEmail = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList']['contactPerson']['email']['email'];
           

            // get the list of all the tickets 
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];
            $flightNumber = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptionList']['bookFlightSegmentList']['flightSegment']['flightNumber'];
            
            if (array_key_exists('couponInfoList', $ticketItemList)) {
                if (!array_key_exists('asvcSsr', $ticketItemList['couponInfoList'])) {
                    // dump('non asvcSsr ran');
                    $paymentReferenceID = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                    $invoice_number = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                    $paymentType = $ticketItemList['paymentDetails']['paymentDetailList']['paymentType'];
                    $amount = $ticketItemList['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                    $orderID = $ticketItemList['paymentDetails']['paymentDetailList']['orderID'];
                    $ticketId = $ticketItemList['ticketDocumentNbr'];
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']; // meant to be an array but an empty string when nothing is found;
                    

                    $invoiceExists = InvoiceRecord::where('code', $invoice_number)->first();

                    if (!$invoiceExists)  {

                        $invoice = InvoiceRecord::create([
                            'code' => $invoice_number,
                            'amount' => $amount,
                            'order_id' => $orderID,                                
                            'ticket_number' => $ticketId,
                            'reason_for_issuance' => $reasonForIssuance,
                        ]);
                        

                        InvoiceItem::create([
                            'invoice_id' => $invoice->id,
                            'product' => $reasonForIssuance ?? 'ticket', // baggages or ticket shopping
                            'quantity' => '',
                            'price' => $amount
                        ]);
                        
                        TransactionRecord::create([
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'flight_id' => $flightNumber,
                            'amount' => $amount,
                            'ticket_type' => 'ticket',
                            'user_id' => $user->id,
                            'payment_reference' => $paymentReferenceID,
                            'invoice_number' => $invoice->id,
                            'reason_for_issuance' => $reasonForIssuance
                        ]); 

                    }
                
                }
                else {                        

                    // dump('ssr ran');
                    $paymentReferenceID = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                    $invoice_number = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                    $paymentType = $ticketItemList['paymentDetails']['paymentDetailList']['paymentType'];
                    $orderID = $ticketItemList['paymentDetails']['paymentDetailList']['orderID'];
                    $ticketId = $ticketItemList['ticketDocumentNbr'];
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                    $amount = $ticketItemList['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                    


                    $invoiceExists = InvoiceRecord::where('code', $invoice_number)->first();

                    if (!$invoiceExists)  {
                        $invoice = InvoiceRecord::create([
                            'code' => $invoice_number,
                            'amount' => $amount,
                            'order_id' => $orderID,                                
                            'ticket_number' => $ticketId,
                            'reason_for_issuance' => $reasonForIssuance,
                        ]);
                        

                        InvoiceItem::create([
                            'invoice_id' => $invoice->id,
                            'product' => $reasonForIssuance, // baggages or ticket shopping
                            'quantity' => '',
                            'price' => ''
                        ]);
                        
                        TransactionRecord::create([
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'flight_id' => $flightNumber,
                            'amount' => $amount,
                            'ticket_type' => 'Ancilary',
                            'user_id' => $user->id,
                            'payment_reference' => $paymentReferenceID,
                            'invoice_number' => $invoice->id,+
                            'reason_for_issuance' => $reasonForIssuance
                        ]);
                    } 
                } 
            
            
            } else {
                foreach($ticketItemList as $ticketItem) {
                    // if ($ticketItem["status"] == "OK") {
                        // dump($user->first_name);
                    if (!array_key_exists('asvcSsr', $ticketItem['couponInfoList'])) {
                        // dump('non asvcSsr ran');
                        $paymentReferenceID = $ticketItem['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                        $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                        $paymentType = $ticketItem['paymentDetails']['paymentDetailList']['paymentType'];
                        $amount = $ticketItem['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                        $orderID = $ticketItem['paymentDetails']['paymentDetailList']['orderID'];
                        $ticketId = $ticketItem['ticketDocumentNbr'];
                        $reasonForIssuance = $ticketItem['reasonForIssuance']; // meant to be an array but an empty string when nothing is found;
                        

                        $invoiceExists = InvoiceRecord::where('code', $invoice_number)->first();

                        if (!$invoiceExists)  {

                            $invoice = InvoiceRecord::create([
                                'code' => $invoice_number,
                                'amount' => $amount,
                                'order_id' => $orderID,                                
                                'ticket_number' => $ticketId,
                                'reason_for_issuance' => $reasonForIssuance,
                            ]);
                            

                            InvoiceItem::create([
                                'invoice_id' => $invoice->id,
                                'product' => $reasonForIssuance ?? 'ticket', // baggages or ticket shopping
                                'quantity' => '',
                                'price' => $amount
                            ]);
                            
                            TransactionRecord::create([
                                'transaction_type' => $transactionType,
                                'peace_id' => $peaceId,
                                'flight_id' => $flightNumber,
                                'amount' => $amount,
                                'ticket_type' => 'ticket',
                                'user_id' => $user->id,
                                'payment_reference' => $paymentReferenceID,
                                'invoice_number' => $invoice->id,
                                'reason_for_issuance' => $reasonForIssuance
                            ]); 

                        }
                    
                    }
                    else {                        

                        // dump('ssr ran');
                        $paymentReferenceID = $ticketItem['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                        $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                        $paymentType = $ticketItem['paymentDetails']['paymentDetailList']['paymentType'];
                        $orderID = $ticketItem['paymentDetails']['paymentDetailList']['orderID'];
                        $ticketId = $ticketItem['ticketDocumentNbr'];
                        $reasonForIssuance = $ticketItem['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                        $amount = $ticketItem['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                        


                        $invoiceExists = InvoiceRecord::where('code', $invoice_number)->first();

                        if (!$invoiceExists)  {
                            $invoice = InvoiceRecord::create([
                                'code' => $invoice_number,
                                'amount' => $amount,
                                'order_id' => $orderID,                                
                                'ticket_number' => $ticketId,
                                'reason_for_issuance' => $reasonForIssuance,
                            ]);
                            

                            InvoiceItem::create([
                                'invoice_id' => $invoice->id,
                                'product' => $reasonForIssuance, // baggages or ticket shopping
                                'quantity' => '',
                                'price' => ''
                            ]);
                            
                            TransactionRecord::create([
                                'transaction_type' => $transactionType,
                                'peace_id' => $peaceId,
                                'flight_id' => $flightNumber,
                                'amount' => $amount,
                                'ticket_type' => 'Ancilary',
                                'user_id' => $user->id,
                                'payment_reference' => $paymentReferenceID,
                                'invoice_number' => $invoice->id,+
                                'reason_for_issuance' => $reasonForIssuance
                            ]);
                        } 
                    }                
                }
            }
            

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
