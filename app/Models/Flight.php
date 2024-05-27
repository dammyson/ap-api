<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ["plane:id,code", 'origin:id,name', 'destination:id,name'];

    public function plane()
    {
        return $this->belongsTo(Plane::class, 'plane_id')->withDefault([
            'code' => 'N/A',
            "name" => "N/A"
        ]);
    }

    public function origin()
    {
        return $this->belongsTo(Airport::class, "origin_id");
    }

    public function destination()
    {
        return $this->belongsTo(Airport::class, "destination_id");
    }

    public function ticketTypes()
    {
        return $this->hasMany(FlightTicketType::class);
    }
}
