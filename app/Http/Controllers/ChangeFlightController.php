<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Services\Soap\CancelBookingBuilder;

class ChangeFlightController extends Controller
{
    //
    protected $cancelBookingBuilder;
    protected $craneOTASoapService;

    public function __construct(CancelBookingBuilder $cancelBookingBuilder)
    {
        $this->cancelBookingBuilder = $cancelBookingBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
    }

    public function changeFlight(Request $request) {
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
}
