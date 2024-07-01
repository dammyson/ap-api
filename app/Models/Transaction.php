<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ref',
        'invoice_id',
        'transaction_type_id',
        'amount',
        'description',
        'transaction_date',
        'is_flight',
    ];
}
