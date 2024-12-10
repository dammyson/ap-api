<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'discount', 'minimum_points'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'tier_users')
                    ->withPivot('is_current', 'expires_at')
                    ->withTimestamps();
    }

        public function isEligible($points)
    {
        return $points >= $this->minimum_points;
    }
}
