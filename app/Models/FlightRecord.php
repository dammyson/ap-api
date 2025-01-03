<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'origin', 
        'destination', 
        'arrival_time', 
        'departure_time',
        'peace_id', 
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
        'amount'
    ];
}
