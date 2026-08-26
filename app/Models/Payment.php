<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'ref',
        'user_id',
        'amount',
        'currency',
        'channel',
        'method',
        'purpose',
        'payment_status',
        'booking_api_status',
        'completed_script_status',
        'booking_id',
        'booking_reference_id',
        'invoice_id',
        'failure_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
