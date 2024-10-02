<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceRecord extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'code',
        'amount',
        'order_id',                                
        'ticket_number',
    ];
}
