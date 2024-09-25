<?php

namespace App\Models;

use App\Observers\AdminObserver;
use App\Models\Admin\ActivityLog;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


// #[ObservedBy([AdminObserver::class])]
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['user_name', 'email', 'password', 'image_url', 'role', 'phone_number'];

    protected $hidden = ['password', 'remember_token'];

    public function activityLogs() {
        return $this->hasMany(ActivityLog::class, 'admin_id');
    }
    

    protected static function boot()
    {
        parent::boot();
        static::observe(AdminObserver::class);
    }
}
