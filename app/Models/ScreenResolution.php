<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenResolution extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'screen_resolution'];
    
}
