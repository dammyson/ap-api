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
        'passenger_type',
        'quantity_of passenger',
        'phone_number',
        'trip_type',
        'booking_id'
    ];
}
