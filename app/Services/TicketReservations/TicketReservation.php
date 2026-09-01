<?php

namespace App\Services\TicketReservations;



use App\Models\Flight;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Events\UserActivityLogEvent;
use App\Exceptions\HititException;
use App\Http\Controllers\Soap\Booking\BookingController;
use App\Models\Payment;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Services\Utility\CheckArray;
use App\Services\Utility\GetPointService;

class TicketReservation 
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
    
    public function commit(array $data)
    {   
        try {

            $bookingId = $data['booking_id'];
            $bookingReferenceId = $data['booking_reference_id'];
            $paidAmount = $data['paid_amount'];
            $invoiceId = $data['invoice_id'];
            $deviceType = $data['device_type'];
            $paymentMethod = $data['payment_method'] ?? null;
            $paymentChannel = $data['payment_channel'] ?? null;
            $preferredCurrency = $data['preferred_currency'] ?? null;
            $paymentId = $data['payment_id'] ?? null;


            $user = auth()->user();
           
            
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
                $invoiceAmount, 
            
            );

            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';

            $response = $this->craneOTASoapService->run($function, $xml);
            


            if ($payment) {
                $payment->update([
                    'booking_api_status' => 'completed',
                ]);
            }
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
            
            $invoice->is_paid = true;
            $invoice->save();

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

            
            foreach($ticketItemList as $index => $ticketItem) {
                if (isset($ticketItem['couponInfoList']) && $this->checkArray->isAssociativeArray($ticketItem['couponInfoList'])) {
                    $ticketItemList[$index]['couponInfoList'] =  [$ticketItem['couponInfoList']];
                }
            }

            if (!$user->is_guest) {
                $routes = $this->bookingController->readBooking($bookingId, $bookingReferenceId);    
                
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
            
        }  catch (HititException $e) {
            Log::error('HITIT TICKET VERIFICATION ERROR', [
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);


            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
            ], 400);

        } catch (\Throwable $th) {

            if ($payment && $payment->booking_api_status !== 'completed') {
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
                "message" => "something went wrong"
                
                
            ], 500);
        }  
    
           
    }


    public function viewBaseFarePaymentInfo(array $data) {

        try {
            $routes = $data['routes'];
            $noOfPassengers = $data['noOfPassengers'];
            $preferredCurrency = $data['preferredCurrency'];
            $bookingId = $data['bookingId'];
            $bookingReferenceID = $data['bookingReferenceID'];

            $user = auth()->user();
            
            // add a forloop here incase of multiple route
            $redemptionPoint = 0;
            foreach($routes as $route) {
                $redemptionPoint += $this->getPointService->getFlightRedemptionPoints($route['route'], $route['class'], $route['type']);

            }
            
            $totalRedemptionPoint = $redemptionPoint * $noOfPassengers; 
            $peacePoint = $user->points;
        

            if ($peacePoint < $totalRedemptionPoint) {
                throw new \Exception("Insufficient Points");
            }
            //// read expected amount from ticketReservation (this is the accurate amount)
            $ticketReservationFunction = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            
    
            $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                $preferredCurrency,
                $bookingId,
                $bookingReferenceID
            );    
            
            $ticketReservationResponse = $this->craneOTASoapService->run($ticketReservationFunction, $xml);
            
            if (!isset($ticketReservationResponse['AirTicketReservationResponse'])) {
                throw new \Exception('Invalid ticket reservation response');
            }
           
            $ticketItemList = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]['ticketInfo']['ticketItemList'];
            
            if ($this->checkArray->isAssociativeArray($ticketItemList)) { 
                $ticketItemList = [$ticketItemList];

            }
            $baseFare = 0;

            foreach($ticketItemList as $ticketItem) {
                // $baseFare += $ticketItem['pricingInfo']['baseFare']['amount']['value'];
                $baseFare += $ticketItem["pricingOverview"]["totalBaseFare"]["value"];
            }


            //substract base fare from expected amount to know how much the user is felt to pay
            $expectedAmount = $ticketReservationResponse["AirTicketReservationResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
        
            $amountRemaining = $expectedAmount - $baseFare;

            return [
                "amountRemaining" => $amountRemaining,
                "expectedAmount" => $expectedAmount,
                "baseFare" => $baseFare,
                "redemptionPoint" => $redemptionPoint,
                "totalRedemptionPoint" => $totalRedemptionPoint
            ];

        } catch (\Throwable $th) {
            throw $th;
        }
        
    }

}