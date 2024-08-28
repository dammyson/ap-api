<?php

namespace App\Http\Controllers;

use App\Jobs\AutoCancelBookingJob;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //
    public function getBooking(Request $request){

        $number = $request->query('number');
        $last_name = $request->query('last_name');
       
        $booking = Booking::with('invoice','tickets')->where("booking_number", $number)->where("last_name", $last_name)->first();

       return response()->json($booking);
    } 

    public function bookOnHold(Request $request, Booking $booking) {
        // dump('I ran before the job');

        AutoCancelBookingJob::dispatch($booking)->delay(now()->addMinutes(5));
    }
}
