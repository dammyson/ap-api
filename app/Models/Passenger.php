<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'date_of_birth',
        'sex',
        'country',
        'passport_number',
        'is_blind',
        'is_deaf',
        'needs_mobility_assistance',
        'is_contact_person',
        'invoice_type',
        'user_category', // Add this line
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
