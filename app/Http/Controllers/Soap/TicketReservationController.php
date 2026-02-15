<?php

namespace App\Http\Controllers\Soap;

use App\Models\Flight;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\RecentActivity;
use Illuminate\Support\Facades\Log;
use App\Events\UserActivityLogEvent;
use App\Http\Controllers\Controller;
use App\Services\Utility\CheckArray;
use App\Services\Utility\GetPointService;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Controllers\Soap\Booking\BookingController;
use App\Http\Requests\Soap\Ticket\TicketReservationViewOnlyRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReservationNotification;

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
            
            $response = $this->craneOTASoapService->run($function, $xml);

            return $response;

            
            
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  

        return response()->json([
            'error' => false,
            'invoice_id' => $invoice->id,
            'booking_data' => $response
        ]);

    }

    


    public function ticketReservationCommit($bookingId, $bookingReferenceId, $paidAmount, $invoiceId, $deviceType, $paymentMethod = null, $paymentChannel = null, $preferredCurrency = null) { 
        $user = auth()->user();
        // dd($user->id);
        
        $invoice = Invoice::find($invoiceId);

        // dd($invoice->amount);
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
            $invoiceAmount, // later on we would substract our own profit from paidAmount and return the send the rest to the SOAP
          
        );

        try {
            
            // $user = auth()->user();
            // $peaceId = $user ? $user->peace_id : null;      
            // $guestToken = !$user ? Session::get('guest_session_token'): null;
            // $guestToken = $request->input('guest_session_token');
            
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
           
            dump($response);
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
           
            if (!array_key_exists('AirTicketReservationResponse', $response)) {
                return response()->json([
                    'error' => true,
                    'message' => "no new addition to ticket",
                    'paidAmount' => $paidAmount,
                ], 500);
            }        

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

           
            RecentActivity::create([
                "title" => "Ticket Payment",
                "description" => $user ? " {$user->first_name} made payment for flight with booking id {$bookingId} " : "Guest made payment for fligth with booking Id {$bookingId}"
            ]);


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
                $user->notify(new ReservationNotification($bookingId, $bookingReferenceId,$bookOriginDestinationOptionLists, $airTravelerList, $specialRequestDetails, $ticketItemList));


            } else {
               $firstPassengerEmail = $airTravelerList[0]['contactPerson']['email']['email']; 
                Notification::route('mail', $firstPassengerEmail)
                        ->notify(new ReservationNotification($bookingId, $bookingReferenceId, $bookOriginDestinationOptionLists, $airTravelerList, $specialRequestDetails, $ticketItemList));
            }

            

            // dump($response);

        // return $ticketItemList;



            return response()->json([
                "error" => false,
                "points" => (!$user->is_guest) ? $totalPoint : 0,
                "amount" => $paidAmount,
                "message" => "transaction successfully recorded"
            ], 200); 
            
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,  
                // "message" => "something went wrong",
                "message" => $th->getMessage(),
                
                
            ], 500);
        }  
    }
    
}
