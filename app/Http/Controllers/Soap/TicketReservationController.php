<?php

namespace App\Http\Controllers\Soap;

use App\Models\Flight;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Events\UserActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Services\Utility\CheckArray;
use App\Services\Utility\GetPointService;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Controllers\Soap\Booking\BookingController;
use App\Http\Requests\Soap\Ticket\TicketReservationViewOnlyRequest;
use App\Models\Payment;

class TicketReservationController extends Controller
{

    protected $ticketReservationRequestBuilder;    
    protected $craneOTASoapService;
    protected $checkArray;
    protected $bookingController;
    protected $getPointService;

    public function __construct(TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray, BookingController $bookingController, GetPointService $getPointService)
    {
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->checkArray = $checkArray;
        $this->bookingController = $bookingController;
        $this->getPointService = $getPointService;
    }

    public function ticketReservationViewOnly(TicketReservationViewOnlyRequest $request) {
        $bookingId = $request->input('ID');
        $bookingReferenceId = $request->input('referenceID');
        $preferredCurrency = $request->input('preferred_currency');

        try {
    
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            
    
            $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                $preferredCurrency,
                $bookingId,
                $bookingReferenceId
            );    
            
            // dump($xml);
            $response = $this->craneOTASoapService->run($function, $xml);

            return $response;

            
            
        } catch (\Throwable $th) {

            Log::error('ERROR VIEWING TICKET RESERVATION', [
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
    
    public function ticketReservationCommit($bookingId, $bookingReferenceId, $paidAmount, $invoiceId, $deviceType, $paymentMethod = null, $paymentChannel = null, $preferredCurrency = null, $paymentId=null) { 
        $user = auth()->user();
        // dd($user->id);

        // dd($preferredCurrency);
        
        $invoice = Invoice::find($invoiceId);
        
        if (!$invoice) {
                return response()->json([
                    "error" => true,
                    "message" => "No record of invoice"
                ], 404);
            } 
        
        
        $payment = Payment::find($paymentId);
           

        $invoiceAmount = $invoice->amount;

      

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
            $invoiceAmount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
          
        );


        try {
            
            
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
           
           

            if (array_key_exists('AirTicketReservationResponse', $response)) {
                $payment->update([
                    'booking_api_status' => 'completed',
                ]);
            }

            if (!array_key_exists('AirTicketReservationResponse', $response)) {
                return response()->json([
                    'error' => true,
                    'message' => "no new addition to ticket",
                    'paidAmount' => $paidAmount,
                ], 500);
            }    

            // dd($response);
            $totalDistance = 0;

            $bookOriginDestinationOptionLists =  $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airItinerary']['bookOriginDestinationOptions']['bookOriginDestinationOptionList'];
            
            if ($this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists)) {
                $bookOriginDestinationOptionLists = [$bookOriginDestinationOptionLists];
            }            
    
            foreach($bookOriginDestinationOptionLists as $bookOriginDestinationOptionList) {
                $totalDistance += $bookOriginDestinationOptionList['bookFlightSegmentList']['flightSegment']['distance'];
            }  
    
            $user->addMilesFromKilometers($totalDistance);
           
            Flight::where('booking_id', $bookingId)->update([
                'is_paid' => true
            ]);
            
            // dd($response);
            $invoice->is_paid = true;
            $invoice->save();

            // AirTicketReservationResponse
           
             

            // get the list of all the tickets 
            $transactionType = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $ticketItemList = $response['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList'];
          
            // Device::where('user_id', $user->id)->first();
            $deviceType = $user ? $user->device_type : $deviceType;
           

            if ($this->checkArray->isAssociativeArray($ticketItemList)) {
                $ticketItemList = [$ticketItemList];
            }

            foreach($ticketItemList as $ticketItem) {
                // if ($ticketItem["status"] == "OK") {
                $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                
                if (!array_key_exists('asvcSsr', $ticketItem['couponInfoList'])) {
                    // dump('non asvcSsr ran');
                    
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                            
                    ], [
                        'amount' => $paidAmount,
                        'booking_id' => $bookingId,
                        'transaction_type' => $transactionType,
                        'booking_id' => $bookingId,
                        'ticket_type' => 'ticket',
                        'user_id' =>  $user->id,
                        'invoice_id' => $invoice->id,
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
                        'amount' => $paidAmount,
                        'booking_id' => $bookingId,
                        'transaction_type' => $transactionType,
                        'ticket_type' => 'Ancillary',
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id,
                        'device_type' => $deviceType,
                        'is_flight' => true,
                        "payment_method" => $paymentMethod ?? "not applicable",
                        "payment_channel" => $paymentChannel ?? "not applicable",
                        'currency' => $preferredCurrency

                    ]); 
                }                
            }
        

            $description = "made for a payment of {$paidAmount} for flight with booking id {$bookingId}";
            event(new UserActivityLogEvent($user, "ticket payment", $description));

           




            $specialRequestDetails = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['specialRequestDetails'];
            $airTravelerList = $response['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'];
          
            if ($this->checkArray->isAssociativeArray($airTravelerList)) {
                $airTravelerList = [$airTravelerList];
            }
            if ($this->checkArray->isAssociativeArray($specialRequestDetails)) {
                $specialRequestDetails = [$specialRequestDetails];
            }

            // dd($ticketItemList);
            
            foreach($ticketItemList as $index => $ticketItem) {
                if (isset($ticketItem['couponInfoList']) && $this->checkArray->isAssociativeArray($ticketItem['couponInfoList'])) {
                    $ticketItemList[$index]['couponInfoList'] =  [$ticketItem['couponInfoList']];
                }
            }

            if (!$user->is_guest) {
                $routes = $this->bookingController->readBooking($bookingId, $bookingReferenceId);
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
                "points" => (!$user->is_guest) ? $totalPoint : 0,
                "amount" => $paidAmount,
                "message" => "transaction successfully recorded"
            ], 200); 
            
        } catch (\Throwable $th) {

            if ($payment->booking_api_status !== 'completed') {
                $payment->update([
                    'booking_api_status' => 'failed',
                    'failure_reason' => $th->getMessage(),
                ]);
            }


            Log::error('TICKET RESERVATION ERROR', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
    
            return response()->json([
                "error" => true,  
                // "message" => "something went wrong",
                "response" => $response,
                "message" => $th->getMessage(),
                
                
            ], 500);
        }  
    }
    
}
