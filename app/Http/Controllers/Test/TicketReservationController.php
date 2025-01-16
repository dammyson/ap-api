<?php

namespace App\Http\Controllers\Test;

use Carbon\Carbon;
use App\Models\Device;
use App\Models\Wallet;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use App\Events\UserActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Test\Booking\BookingRequestController;
use App\Services\Utility\CheckArray;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Requests\Test\Ticket\TicketReservationViewOnlyRequest;
use App\Models\RecentActivity;
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


    public function ticketReservationViewOnly(TicketReservationViewOnlyRequest $request) {
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $preferredCurrency = $request->input('preferred_currency');

        // $function = 'http://impl.soap.ws.crane.hititcs.com/ticketReservationViewOnlyRT';

        $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
            $preferredCurrency,
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

    public function testTicketReservationCommit(Request $request) {
        
       
        $bookingId = $request->input('ID');
        $bookingReferenceId = $request->input('reference_id');
        $paidAmount = $request->input('value');
        $preferredCurrency = $request->input('preferred_currency');
        
        $xml = $this->ticketReservationRequestBuilder->ticketReservationCommit(  
            $preferredCurrency,     
            $bookingId,
            $bookingReferenceId,           
            $paidAmount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
          
        );
        // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

        $response = $this->craneOTASoapService->run($function, $xml);
        dd($response);

    }

    public function ticketReservationCommit($preferredCurrency, $bookingId, $bookingReferenceId, $paidAmount, $invoiceId, $deviceType = null) { 
        $invoice = Invoice::find($invoiceId);
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
            $preferredCurrency,         
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
                    'message' => "no new addition to ticket",
                    'paidAmount' => $paidAmount,
                    "response" => $response
                ], 500);
            }        

            // get the list of all the tickets 
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];
            // for is_associative array at for this bookOriginDestinationOptionList
            // $flightNumber = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][index]['bookFlightSegmentList']['flightSegment']['flightNumber'];
            
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
                     
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                    ], [
                        'amount' => $paidAmount,
                        'transaction_type' => $transactionType,
                        'peace_id' => $peaceId,
                        'ticket_type' => 'ticket',
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id,
                        'device_type' => $deviceType,
                        'is_flight' => true,
                        'currency' => $preferredCurrency
                    ]);                    
                
                } else { 
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                           
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                    ],
                    [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice->device_type,
                            'is_flight' => true,
                            'currency' => $preferredCurrency
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
                           
                        Transaction::firstOrCreate([
                            "invoice_number" => $invoice_number,                            
                        ], [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'ticket_type' => 'ticket',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice->device_type,
                            'is_flight' => true,
                            'currency' => $preferredCurrency
                        ]);                          
                    
                    }
                    else {      
                        $reasonForIssuance = $ticketItem['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                                    
                        Transaction::firstOrCreate([
                            "invoice_number" => $invoice_number,                            
                        ], [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'peace_id' => $peaceId,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user->id,
                            'invoice_id' => $invoice->id,
                            'device_type' => $userDevice->device_type,
                            'is_flight' => true,
                            'currency' => $preferredCurrency
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
                "amount" => $paidAmount,
                "message" => "transaction successfully recorded"
            ], 200);           
            // }   
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    public function guestTicketReservationCommit($preferredCurrency, $bookingId, $bookingReferenceId, $paidAmount, $invoiceId, $deviceType) { 
        $invoice = Invoice::find($invoiceId);
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
            $preferredCurrency,           
            $bookingId,
            $bookingReferenceId,           
            $paidAmount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
          
        );

        try {
            
            // $user = auth()->user();
            // $peaceId = $user ? $user->peace_id : null;      
            // $guestToken = !$user ? Session::get('guest_session_token'): null;
            // $guestToken = $request->input('guest_session_token');
            
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
           
            $invoice->is_paid = true;
            $invoice->save();
           
            if (!array_key_exists('AirTicketReservationResponse', $response)) {
                return response()->json([
                    'error' => true,
                    'message' => "no new addition to ticket",
                    'paidAmount' => $paidAmount,
                    "response" => $response
                ], 500);
            }        

            // get the list of all the tickets 
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];
            // for is_associative array at for this bookOriginDestinationOptionList
            // $flightNumber = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'][index]['bookFlightSegmentList']['flightSegment']['flightNumber'];
            
            $user = auth()->user();
            // Device::where('user_id', $user->id)->first();
            $deviceType = $user ? $user->device_type : $deviceType;
           
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
                     
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                    ], [
                        'amount' => $paidAmount,
                        'transaction_type' => $transactionType,
                        // 'peace_id' => $user ? $user->peace_id : null,
                        'ticket_type' => 'ticket',
                        'user_id' => $user ? $user->id : null,
                        'invoice_id' => $invoice->id,
                        'device_type' => $deviceType,
                        'is_flight' => true,
                        'currency' => $preferredCurrency
                    ]);                    
                
                } else { 
                    $reasonForIssuance = $ticketItemList['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                           
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                        ],
                        [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user ? $user->id : null,
                            'invoice_id' => $invoice->id,
                            'device_type' => $deviceType,
                            'is_flight' => true,                            
                            'currency' => $preferredCurrency
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
                           
                        Transaction::firstOrCreate([
                            "invoice_number" => $invoice_number,                            
                        ], [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'ticket_type' => 'ticket',
                            'user_id' => $user ? $user->id : null,
                            'invoice_id' => $invoice->id,
                            'device_type' => $deviceType,
                            'is_flight' => true,                            
                            'currency' => $preferredCurrency
                        ]);                          
                    
                    }
                    else {      
                        $reasonForIssuance = $ticketItem['reasonForIssuance']['explanation']; // meant to be an array but an empty string when nothing is found;
                                                    
                        Transaction::firstOrCreate([
                            "invoice_number" => $invoice_number,                            
                        ], [
                            'amount' => $paidAmount,
                            'transaction_type' => $transactionType,
                            'ticket_type' => 'Ancillary',
                            'user_id' => $user ? $user->id : null,
                            'invoice_id' => $invoice->id,
                            'device_type' => $deviceType,
                            'is_flight' => true,
                            'currency' => $preferredCurrency

                        ]); 
                    }                
                }
            }

            $description = "made for a payment of {$paidAmount} for flight with booking id {$bookingId}";
            event(new UserActivityLogEvent($user, "ticket payment", $description));

            $guest = "Guest";
           
            RecentActivity::create([
                "title" => "Ticket Payment",
                "description" => $user ? " {$user->first_name} made payment for flight with booking id {$bookingId} " : "Guest made payment for fligth with booking Id {$bookingId}"
            ]);

            if ($user) {
                $routes = $this->bookingRequestController->readBooking($bookingId, $bookingReferenceId);
                // dump($response);     
                
                $totalPoint = 0;
                foreach($routes as $route) {
                    ['points' => $points, 'tierPoints' => $tierPoints]= $this->getPointService->domesticPoints($route["route"], $route["class"]);
    
                   $totalPoint += $points;
                }
    
                $user->addPoints($totalPoint, "point add for ticketing flight");

            }

            return response()->json([
                "error" => false,
                "points" => $user ? $totalPoint : 0,
                "amount" => $paidAmount,
                "message" => "transaction successfully recorded"
            ], 200);           
            // }   
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }  
    }

    
}
