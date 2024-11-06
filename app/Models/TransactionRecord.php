<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRecord extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = [ 
        'transaction_type', 
        'amount', 
        'user_id',
        'peace_id', 
        'invoice_number', 
        'invoice_id',
        'ticket_type',
        'device_type',
        'day_of_week'
        
    ];

    public function user() {
        return $this->belongsTo(User::class, 'peace_id', 'peace_id');
    }
}
