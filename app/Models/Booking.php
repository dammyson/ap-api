<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, HasUuids;


    protected $fillable = ['peace_id', 'last_name', 'booking_id', 'invoice_id', 'booking_reference_id', 'is_cancelled', 'guest_session_token', 'request_ref'];



    public function user() 
    {
        return $this->belongsTo(User::class, 'peace_id', 'peace_id');
    }
}
