<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin', 
        'destination', 
        'arrival_time', 
        'departure_time',
        'peace_id', 
        'guest_session_token',
        'passenger_name',
        'passenger_type',
        'trip_type',
        'booking_id',
        'origin_city',
        'destination_city',
        'ticket_type',
        'flight_number',
        'flight_distance',
        'flight_duration',
        'payment_expires_at',
        'invoice_id'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class, 'peace_id', 'peace_id');
    }
}
