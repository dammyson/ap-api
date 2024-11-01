<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralActivity extends Model
{
    use HasFactory;

    protected $fillable = ['referrer_peace_id', 'referrer_user_name', 'referrer_points_earned', 'referee_peace_id', 'referee_user_name', 'referee_id'];

    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }
}
