<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRecord extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'transaction_type', 
        'peace_id', 
        'flight_id',
        'amount', 
        'ticket_type', 
        'user_id', 
        'payment_reference',
        'invoice_number'
    ];
}
