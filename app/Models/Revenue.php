<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    // add flight_ticket_type depending on soap api operation
    protected $fillable = ['amount', 'day_of_week', 'sales_type', 'device_type'];

    public function device() {
        return $this->belongsTo(Device::class);
    }
}
