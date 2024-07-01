<?php

namespace App\Services\Transaction;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Transactions 
{
    public function createTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            $transaction = new Transaction();
            $transaction->user_id = $data['user_id'];
            $transaction->ref = $this->generateRef();
            $transaction->invoice_id = $data['invoice_id'];
            $transaction->transaction_type_id = $data['transaction_type_id'];
            $transaction->amount = $data['amount'];
            $transaction->description = $data['description'];
            $transaction->transaction_date = Carbon::now();
            $transaction->is_flight = $data['is_flight'] ?? true;
            $transaction->save();
            return $transaction;
        });
    }

    private function generateRef()
    {
        return strtoupper(Str::random(6) . Str::random(4, '0123456789')) . '-' . time();
    }

}