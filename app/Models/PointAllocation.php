<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointAllocation extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'admin_user_name','user_id', 'user_name', 'point_allocated', 'reason_of_allocation', 'survey_id'];
}
