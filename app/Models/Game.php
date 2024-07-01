<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['game_category_id', 'name', 'description'];

    public function category()
    {
        return $this->belongsTo(GameCategory::class);
    }

    public function rules()
    {
        return $this->hasMany(GameRule::class);
    }

    public function gamePlays()
    {
        return $this->hasMany(GamePlay::class);
    }
}
