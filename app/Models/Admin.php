<?php

namespace App\Models;

use App\Observers\AdminObserver;
use App\Models\Admin\AdminActivityLog;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

// #[ObservedBy([AdminObserver::class])]
class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory,  SoftDeletes, Notifiable;

    protected $fillable = [
        'user_name', 
        'email', 
        'password', 
        'image_url', 
        'role', 
        'phone_number'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function adminActivityLogs() {
        return $this->hasMany(AdminActivityLog::class, 'admin_id');
    }
    

    protected static function boot()
    {
        parent::boot();
        static::observe(AdminObserver::class);
    }
}
