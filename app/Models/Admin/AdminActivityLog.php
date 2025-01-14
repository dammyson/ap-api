<?php

namespace App\Models\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'activity_type', 'description', 'ip_address'];

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
