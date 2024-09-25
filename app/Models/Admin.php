<?php

namespace App\Models;

use App\Observers\AdminObserver;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;


// #[ObservedBy([AdminObserver::class])]
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['user_name', 'email', 'password', 'image_url', 'role', 'phone_number'];

    protected $hidden = ['password', 'remember_token'];

    protected static function boot()
    {
        parent::boot();
        static::observe(AdminObserver::class);
    }
}
