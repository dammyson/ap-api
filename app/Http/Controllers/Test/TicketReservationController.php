<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Ticket\TicketReservationCommitRequest;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Requests\Test\Ticket\TicketReservationCommitRTRequest;
use App\Http\Requests\Test\Ticket\TicketReservationCommitTwoARequest;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRequest;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRTRequest;
use App\Http\Requests\Ticket\TicketReservationViewOnlyTwoARequest;

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
 
        $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';
       
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
            
          $response =  $this->craneOTASoapService->run($function, $xml);
          dd($response);
            
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

        $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

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

       
        $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

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
           $response =  $this->craneOTASoapService->run($function, $xml);

           dd($response);
          
           
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

        $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

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
            
            $response = $this->craneOTASoapService->run($function, $xml);
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

        $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

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
           $response = $this->craneOTASoapService->run($function, $xml);
           dd($response);
           
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

        $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

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

        $response = $this->craneOTASoapService->run($function, $xml);
        dd($response);
    }
}
