<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['flight', "passenger", "flightTicketType"];

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 0:
                return "pending";
                break;
            case 1:
                return "approved";
                break;

            case 2:
                return "cancelled";
                break;

            default:
                return "not defined";
                break;
        }
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function flightTicketType()
    {
        return $this->belongsTo(FlightTicketType::class);
    }

   // Define the relationship
   public function passenger()
   {
       return $this->belongsTo(Passenger::class);
   }

}
