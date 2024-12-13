<?php

namespace App\Http\Controllers\Test;

use Carbon\Carbon;
use App\Models\Device;
use App\Models\Wallet;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\InvoiceRecord;
use App\Models\TransactionType;
use App\Models\TransactionRecord;
use App\Events\UserActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Test\Booking\BookingRequestController;
use App\Services\Utility\CheckArray;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Requests\Test\Ticket\TicketReservationCommitRequest;
use App\Http\Requests\Ticket\TicketReservationViewOnlyTwoARequest;
use App\Http\Requests\Test\Ticket\TicketReservationCommitRTRequest;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRequest;
use App\Http\Requests\Test\Ticket\TicketReservationCommitTwoARequest;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRTRequest;
use App\Services\Utility\GetPointService;

class TicketReservationController extends Controller
{

    protected $ticketReservationRequestBuilder;    
    protected $craneOTASoapService;
    protected $checkArray;
    protected $bookingRequestController;
    protected $getPointService;

    public function __construct(TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray, BookingRequestController $bookingRequestController, GetPointService $getPointService)
    {
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->checkArray = $checkArray;
        $this->bookingRequestController = $bookingRequestController;
        $this->getPointService = $getPointService;
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

    public function testTicketReservationCommit(Request $request) {
        
       
        $bookingId = $request->input('ID');
        $bookingReferenceId = $request->input('reference_id');
        $paidAmount = $request->input('value');
        
        $routes = $this->bookingRequestController->readBooking($bookingId, $bookingReferenceId);

        // dump($response);     
        
        $totalPoint = 0;
        foreach($routes as $route) {
            ['points' => $points, 'tierPoints' => $tierPoints]= $this->getPointService->domesticPoints($route["route"], $route["class"]);

            $totalPoint += $points;
        }
        $user = auth()->user();

        $user->addPoints($totalPoint, "point add for ticketing flight");
        
        dd($user);
        
        $xml = $this->ticketReservationRequestBuilder->ticketReservationCommit(           
            $bookingId,
            $bookingReferenceId,           
            $paidAmount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
          
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

        $response = $this->craneOTASoapService->run($function, $xml);
        dd($response);

    }

    public function ticketReservationCommit($bookingId, $bookingReferenceId, $paidAmount, $invoiceId) { 
        $invoice = InvoiceRecord::find($invoiceId);
        $invoiceAmount = $invoice->amount;

        if (!$invoice) {
            return response()->json([
                "error" => true,
                "message" => "No record of invoice"
            ], 404);
        } 
       

        if ($invoice->is_paid) {
            return response()->json([
                "error" =>  true,
                "message" => "Invoice already paid for"
            ], 500);
        }
        
        $invoiceAmount = $invoiceAmount + 0;

        if ( $paidAmount < $invoiceAmount ) {
            return response()->json([
                "error" => false,
                "message" => "fund payment for ticket is less than calculated"
            ], 500);
        }

        $xml = $this->ticketReservationRequestBuilder->ticketReservationCommit(           
            $bookingId,
            $bookingReferenceId,           
            $paidAmount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
          
        );

        try {
            
            $user = auth()->user();
            $peaceId = $user->peace_id;          

            
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
           
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
            // for is_associative array at for this bookOriginDestinationOptionList
            // $flightNumber = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][index]['bookFlightSegmentList']['flightSegment']['flightNumber'];
            
            $dayOfWeek = Carbon::now()->format('1');
            $userDevice = Device::where('user_id', $user->id)->first();

           
            // if (array_key_exists('couponInfoList', $ticketItemList)) {
            if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                $paymentReferenceID = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['paymentReferenceID'];
                $invoice_number = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                $paymentType = $ticketItemList['paymentDetails']['paymentDetailList']['paymentType'];
                $amount = $ticketItemList['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                $orderID = $ticketItemList['paymentDetails']['paymentDetailList']['orderID'];
                $ticketId = $ticketItemList['ticketDocumentNbr'];
                
                if (!array_key_exists('asvcSsr', $ticketItemList['couponInfoList'])) {                    
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']; // meant to be an array but an empty string when nothing is found;
                     
                    TransactionRecord::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                    ], [
                        'amount' => $paidAmount,
                        'transaction_type' => $transactionType,
                        'peace_id' => $peaceId,
                        'ticket_type' => 'ticket',
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id,
                        'device_type' => $userDevice->device_type ?? "ANDROID",
                        'day_of_week' => $dayOfWeek
                    ]);                    
                
                }

                else { 
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                           
                    TransactionRecord::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                    ],
                    [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice->device_type ?? "ANDROID",
                            'day_of_week' => $dayOfWeek
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
                            "invoice_number" => $invoice_number,                            
                        ], [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'ticket_type' => 'ticket',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice->device_type ?? "ANDROID",
                            'day_of_week' => $dayOfWeek
                        ]);                          
                    
                    }
                    else {      
                        $reasonForIssuance = $ticketItem['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                                    
                        TransactionRecord::firstOrCreate([
                            "invoice_number" => $invoice_number,                            
                        ], [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice->device_type ?? "ANDROID",
                            'day_of_week' => $dayOfWeek
                        ]); 
                    }                
                }
            }

            $description = "made for a payment of {$paidAmount} for flight with booking id {$bookingId}";
            event(new UserActivityLogEvent($user, "ticket payment", $description));


            $routes = $this->bookingRequestController->readBooking($bookingId, $bookingReferenceId);
            // dump($response);     
            
            $totalPoint = 0;
            foreach($routes as $route) {
                ['points' => $points, 'tierPoints' => $tierPoints]= $this->getPointService->domesticPoints($route["route"], $route["class"]);

               $totalPoint += $points;
            }

            $user->addPoints($totalPoint, "point add for ticketing flight");

            return response()->json([
                "error" => false,
                "points" => $totalPoint,
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
           
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }
}
