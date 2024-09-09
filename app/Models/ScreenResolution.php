<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenResolution extends Model
{
    use HasFactory;
    protected $fillable = ['number_of_users', 'screen_resolution'];
    
}
