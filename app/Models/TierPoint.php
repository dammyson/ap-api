<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TierPoint extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_points'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(TierPointTransaction::class);
    }
}
