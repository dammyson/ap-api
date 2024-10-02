<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRecord extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'transaction_type', 
        'amount', 
        'user_id',
        'peace_id', 
        'invoice_number', 
        'ticket_type',
        
    ];
}
