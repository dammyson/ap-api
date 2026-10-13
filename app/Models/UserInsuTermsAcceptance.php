<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInsuTermsAcceptance extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'user_id',
        'insu_terms_and_conds_id',
        'content_hash',
        'accepted_at',
        'ip_address',
        'user_agent'
    ];
}
