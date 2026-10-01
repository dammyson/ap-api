<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class UserTermsAcceptance extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'user_id',
        'terms_and_conditions_id',
        'accepted_at',
        'ip_address',
        'user_agent',
        'content_hash'
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
    ];
}
