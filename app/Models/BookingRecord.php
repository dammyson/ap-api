<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRecord extends Model
{
    use HasFactory;
    
    protected $fillable = ['peace_id', 'booking_id', 'booking_reference_id'];
}
