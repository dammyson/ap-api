<?php

namespace App\Models;

use App\Observers\AdminObserver;
use Laravel\Passport\HasApiTokens;
use App\Models\Admin\AdminActivityLog;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// #[ObservedBy([AdminObserver::class])]
class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens, SoftDeletes, Notifiable;

    protected $fillable = ['user_name', 'email', 'password', 'image_url', 'role', 'phone_number'];

    protected $hidden = ['password', 'remember_token'];

    public function adminActivityLogs() {
        return $this->hasMany(AdminActivityLog::class, 'admin_id');
    }
    

    protected static function boot()
    {
        parent::boot();
        static::observe(AdminObserver::class);
    }
}
