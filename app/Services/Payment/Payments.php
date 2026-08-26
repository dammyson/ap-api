<?php

namespace App\Services\Payment;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class Payments 
{
    public function createPayment(array $data)
    {
        

            if (Payment::where("ref", $data['ref'])->where('channel', $data['channel'])->exists()) {
                throw new \Exception("Payment already processed");
            }

            $payment = new Payment();
            $payment->user_id = $data['user_id'];
            $payment->ref = $data['ref'];
            $payment->amount = $data['amount'];
            $payment->currency = $data['currency'];
            $payment->channel = $data['channel'];
            $payment->method = $data['method'];
            $payment->purpose = $data['purpose'];
            $payment->booking_id = $data['booking_id'] ?? null;
            $payment->booking_reference_id = $data['booking_reference_id'] ?? null;           
            $payment->invoice_id = $data['invoice_id'] ?? null;

            $payment->save();
            return $payment;
        
    }

}