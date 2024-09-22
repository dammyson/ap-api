<?php

namespace App\Http\Controllers\Test;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Requests\Test\Ticket\TicketReservationCommitRequest;
use App\Http\Requests\Ticket\TicketReservationViewOnlyTwoARequest;
use App\Http\Requests\Test\Ticket\TicketReservationCommitRTRequest;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRequest;
use App\Http\Requests\Test\Ticket\TicketReservationCommitTwoARequest;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRTRequest;
use App\Models\TransactionType;

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
            dd($response);
            $txStatus = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList']['status'];
            
            if ($txStatus) {
                $user = $request->user();
                $peaceId = $user->peace_id;

                $amount = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList']['totalAmountText'];
                
                $leadPassengerEmail = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'][0]['contactPerson']['email']['email'];
                $leadPassengerEmail = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList']['contactPerson']['email']['email'];
                $ancilary  = $response["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["ticketItemList"]["asvcSsr"]["amount"]["value"];

                // solution
                $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];

                foreach($ticketItemList as $ticketItem) {
                    if ($ticketItem["status"] == "OK") {
                        dd('I ran');

                        if (!$ticketItem['couponInfoList']['asvcSsr']) {
                            $paymentReferenceID = $ticketItem['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                            $inv = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                            $paymentType = $ticketItem['paymentDetails']['paymentDetailList']['paymentType'];
                            $orderID = $ticketItem['paymentDetails']['paymentDetailList']['orderID'];
                            $statusOfPayment = $ticketItem['status']; // would be OK as checked above;
                            $ticketId = $ticketItem['ticketDocumentNbr'];
                            $reasonForIssuance = $ticketItem['reasonForIssuance']; // meant to be an array but an empty string when nothing is found;

                            $amount = $ticketItem['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                            

                            Transaction::create([
                                'user_name' => $user->user_name,
                                'peace_id' => $peaceId,
                                'amount' => $amount,
                                'payment_reference' => $paymentReferenceID,
                                'inv_number' => $inv,
                                'reason_for_issuance' => $reasonForIssuance,
                                'ticket_number' => '',

                                'ticket_type' => 'ticket',
                                'lead_passenger_email' => $leadPassengerEmail,
                            ]);
                            // 'user_id',
                            // 'ref',
                            // 'invoice_id',
                            // 'transaction_type_id',
                            // 'amount',
                            // 'description',
                            // 'transaction_date',
                            // 'is_flight',
    
    
                            $transactionType = TransactionType::create([
                                'name' => '',
                                'description' => ''
                            ]);
                            Transaction::create([
                                'user_name' => $user->user_name,
                                'peace_id' => $peaceId,
                                'amount' => $amount,
                                'ticket_type' => 'ticket',
                                'lead_passenger_email' => $leadPassengerEmail,
                                
                                'user_id' => '',
                                'ref' => '',
                                'invoice_id' => '',
                                'transaction_type_id' => '',
                                'amount' => $amount,
                                'description' => '',
                                'transaction_date' => '',
                                'is_flight' => ''
            
                            ]);
                        } else  if ($ticketItem['couponInfoList']['asvcSsr']) {
                            $amount = $ticketItem['couponInfoList']['asvcSsr']['amount']['value'];
                            Transaction::create([
                                'user_name' => $user->user_name,
                                'peace_id' => $peaceId,
                                'amount' => $amount,
                                'ticket_type' => 'ancilary',
                                'lead_passenger_email' => $leadPassengerEmail
            
                            ]);
                        
                        }
                    }
                    
                }
                
                Transaction::create([
                    'user_name' => $user->user_name,
                    'peace_id' => $peaceId,
                    'amount' => $amount,
                    'lead_passenger_email' => $leadPassengerEmail

                ]);

                AncillaryRevenue::create([
                    'user_name' => $user->user_name,
                    'peace_id' => $peaceId,
                    'ancilary' => $ancilary
                ]);

                Ticket::create([
                    'user_name' => $user->user_name,
                    'peace_id' => $peaceId,
                    'amount' => $amount,
                ]);
            };

            dd($response);
           
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
