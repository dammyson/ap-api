<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralActivity extends Model
{
    use HasFactory;

    protected $fillable = ['referrer_peace_id', 'referrer_first_name', 'referrer_last_name', 'referee_peace_id', 'referee_first_name', 'referee_last_name'];

}
