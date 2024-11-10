<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Models\InvoiceRecord;
use App\Models\TransactionRecord;
use Illuminate\Support\Facades\DB;
use App\Services\Utility\CheckArray;
use App\Services\Soap\CancelBookingBuilder;
use App\Services\Soap\TicketReservationRequestBuilder;

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

        if (!$booking) {
            return response()->json([
                "error" => true,
                "message" => "booking not found"
            ], 404);
        }
        
        $xml = $this->cancelBookingBuilder->cancelBookingViewOnly( 
            $booking->booking_id, 
            $booking->booking_reference_id
        );

        try {
            $function = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';

            $response = $this->craneOTASoapService->run($function, $xml);

            $totalPenalty = 0;

            if (isset($response['AirCancelBookingResponse']['airBookingList']['ticketInfo'])) {
                if ($this->checkArray->isAssociativeArray($response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'])) {
                    // dd($response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']['couponInfoList']);
                    $totalPenalty = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList']['pricingOverview']['totalPenalty']['value'];

                } else {
                    $ticketItemList = $response['AirCancelBookingResponse']['airBookingList']['ticketInfo']['ticketItemList'];
                    foreach($ticketItemList as $ticketItem) {
                        $totalPenalty += $ticketItem['pricingOverview']['totalPenalty']['value'];
                    }
                }
            }

            $message = "Changing flight will cost a penalty fee of ". $totalPenalty . ", which will be substracted from your refund";

            
            return response()->json([
                'error' => false,
                'message' => $message,
                "total_penalty" => $totalPenalty
            ], 200);

            // if user clicks okay, void the ticket and refund money

            // provide the previous passenger info when the user searches for new flight
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }

    }


    public function changeFlight(Request $request)
    {
        $peaceId = $request->input('peace_id');
        $bookingId = $request->input('booking_id');
        $invoiceId = $request->input('invoice_id');
        $user = $request->user();

        try {
            
            // Retrieve the booking and invoice
            $booking = BookingRecord::where('peace_id', $peaceId)
                ->where('booking_id', $bookingId)
                ->first();

            if (!$booking) {
                return response()->json([
                    'error' => true,
                    'message' => 'Booking not found.'
                ], 404);
            }

            $invoice = InvoiceRecord::find($invoiceId);
            if (!$invoice) {
                return response()->json([
                    'error' => true,
                    'message' => 'Invoice not found.'
                ], 404);
            }

            // Prepare the SOAP request for Ticket Reservation View
            $functionTicketReservation = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';
            $ticketReservationViewXml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                $booking->booking_id,
                $booking->booking_reference_id
            );

            $responseTrv = $this->craneOTASoapService->run($functionTicketReservation, $ticketReservationViewXml);

            // Ensure airTravelerList is an array
            if (isset($responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList']) &&
                $this->checkArray->isAssociativeArray($responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'])) {
                
                $responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'] =
                    [$responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList']];
            }

            $airTravelerList = $responseTrv['AirTicketReservationResponse']['airBookingList']['airReservation']['airTravelerList'] ?? [];

            // Begin database transaction
            DB::beginTransaction();

            // Cancel booking via SOAP
            $cancelFlightXml = $this->cancelBookingBuilder->cancelBookingCommit(
                $booking->booking_id,
                $booking->booking_reference_id
            );

            $cancelBookingFunction = 'http://impl.soap.ws.crane.hititcs.com/CancelBooking';
            $responseCancelFlight = $this->craneOTASoapService->run($cancelBookingFunction, $cancelFlightXml);
            
            // Process refund if applicable
            $refundAmount = 0;
            if (isset($responseCancelFlight['AirCancelBookingResponse']['airBookingList']['ticketInfo']['pricingType'])) {
                $transactionType = $responseCancelFlight['AirCancelBookingResponse']['airBookingList']['ticketInfo']['pricingType'];
                $refundAmount = $responseCancelFlight['AirCancelBookingResponse']['airBookingList']['ticketInfo']['refundPaymentAmountList']['amount']['value'];
                    
                // dump('refund ran');
                if ($transactionType === "REFUND") {
                    $wallet = Wallet::where('user_id', $user->id)->first();
                    if ($wallet) {
                        $wallet->topUp($refundAmount);
                    }

                    // Delete all transactions with the invoice ID
                    TransactionRecord::where('invoice_id', $invoice->id)->delete();
                }
            }

            // Delete the invoice and booking records if they exist
            if ($invoice) {
                $invoice->delete();
                $booking->delete();
            }

            // Commit the transaction
            DB::commit();

            return response()->json([
                'error' => false,
                'airTravelerList' => $airTravelerList,
                'refunded_amount' => $refundAmount,
                'message' => 'Ticket cancelled successfully.'
            ], 200);

        } catch (\Throwable $th) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
