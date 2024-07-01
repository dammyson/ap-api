<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_number',
        'last_name',
        'user_id',
        'invoice_id'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
