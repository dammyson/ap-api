<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = [ 
        'transaction_type', 
        'amount', 
        'user_id',
        'peace_id', 
        'invoice_number',
        'is_flight',
        'invoice_id',
        'ticket_type',
        'device_type',
        'currency'
        
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
