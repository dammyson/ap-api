<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;
// use Illuminate\Foundation\Queue\Queueable;

class AutoCancelBookingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Queueable;

    /**
     * Create a new job instance.
     */
    protected $flutterTransactionId;

    public function __construct(public Booking $booking, $flutterTransactionId)
    {
        // dd("constructor ran");
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        // remove this booking from database

        dd('I ran after one minute');
        
        // if payment not made then delete the booking id or make it invalid
        // $data = Flutterwave::verifyTransaction($transactionID);
        $data = false;

        if (!$data) {
            $this->booking->delete();

        }
        // else do nothing or go next 
    }
}
