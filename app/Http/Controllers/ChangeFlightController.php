<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Services\Soap\CancelBookingBuilder;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Services\Utility\CheckArray;

class ChangeFlightController extends Controller
{
    //
    protected $cancelBookingBuilder;
    protected $ticketReservationRequestBuilder;
    protected $craneOTASoapService;
    protected $checkArray;
    

    public function __construct(CancelBookingBuilder $cancelBookingBuilder, TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray)
    {
        $this->cancelBookingBuilder = $cancelBookingBuilder;
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->checkArray = $checkArray;
        $this->craneOTASoapService = app('CraneOTASoapService');
    }

    public function changeFlightViewOnly(Request $request) {
        $peaceId = $request->input('peace_id');
        $bookingId = $request->input('booking_id');

        $booking = BookingRecord::where('peace_id', $peaceId)
            ->where('booking_id', $bookingId)->first();

       
        // user the what will be deducted and refunded after booking is canceled

        $xml = $this->cancelBookingBuilder->cancelBookingViewOnly(
            "LOS", 
            "P4", 
            "CRANE", 
            "SCINTILLA", 
            "SCINTILLA", 
            "NG", 
            $booking->booking_id, 
            $booking->booking_reference_id,
            "VIEW_ONLY"
        );

        try {
            $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';

            $response = $this->craneOTASoapService->run($function, $xml);
            

            // display response of voiding a ticket to user
            dd($response);

            // if user clicks okay, void the ticket and refund money

            // provide the previous passenger info when the user searches for new flight
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }

    }

    public function changeFlight(Request $request) {
        $peaceId = $request->input('peace_id');
        $bookingId = $request->input('booking_id');


        $booking = BookingRecord::where('peace_id', $peaceId)
            ->where('booking_id', $bookingId)->first();


        $functionTicketReservation = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            
    
        $ticketReservationViewXml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
            $booking->booking_id,
            $booking->booking_reference_id
        );
        
        $responseTrv = $this->craneOTASoapService->run($functionTicketReservation, $ticketReservationViewXml);

      
      
                
        if (isset($responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList']) &&
            $this->checkArray->isAssociativeArray($responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'])) {
                // dd('I ran');
                $responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'] = 
                [$responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList']];  
        }

        $airTravelerList =  $responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'];

        try {   
            
            $cancelFlightXml = $this->cancelBookingBuilder->cancelBookingCommit(            
                $booking->booking_id,
                $booking->booking_reference_id,           
            );
            
            
            $cancelBookingFunction = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';
            
            $responseCancelFlight = $this->craneOTASoapService->run($cancelBookingFunction, $cancelFlightXml);
            
            // delete the booking since it is now cancel
            // $booking->delete();
            // delete Invoice 
            // $invoice = Invoice::find($invoice->id);
            // $invoice->delete();

            // delete all transactions with that invoiceid if payments have been made
            // Transactions::where('invoice_id', $invoice->id)->delete();
          

            // dd($responseCancelFlight);
            
            $transactionType = $responseCancelFlight['AirTicketReservationResponse']['airBookingList']['ticketInfo']['pricingType'];
            $amount = $responseCancelFlight['AirTicketReservationResponse']['airBookingList']['ticketInfo']['refundPaymentAmountList']['amount']['value']; 
            // $amount = $responseCancelFlight['AirTicketReservationResponse']['airBookingList']['ticketInfo']['ticketItemList']['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                        
            if ($transactionType == "REFUND") {
                
                $wallet = Wallet::where('user_id', $user->id);
                $wallet->topUp($amount);

            }


            return response()->json([
                'error' => false,
                'airTravelerList' => $airTravelerList,
                'message' => 'ticket cancelled successfully'
            ], 200);
        
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }
    }
}
