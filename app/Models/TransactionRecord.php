<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRecord extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'user_name', 
        'peace_id', 
        'amount', 
        'ticket_type', 
        'ticket_number', 
        'lead_passenger_email',
        'payment_reference', 
        'invoice_number', 
        'reason_for_issuance', 
        'order_id'
    ];
}
