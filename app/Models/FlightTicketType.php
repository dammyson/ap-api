<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightTicketType extends Model
{
    use HasFactory;
    
    protected $with = ['ticketType'];

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
}
