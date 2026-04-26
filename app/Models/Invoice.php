<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'booking_id',
        'type',
        'amount',
        'currency',
        'is_paid',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
    ];
}
