<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\SurveyUserResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'first_name', 
        'last_name',
        'email',
        'phone_number',
        'peace_id',
        'password',
        'image_url',
        'title',
        'first_name',
        'last_name',
        'nationality',
        'date_of_birth',
        'travel_document'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function surveyUserResponses() {
        return $this->hasMany(SurveyUserResponse::class);
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }

    public function referralActivitiesReferee() {
        return $this->hasOne(ReferralActivity::class, 'referee_peace_id', 'peace_id');
    }

    public function referralActivitiesAsReferrer() {
        return $this->hasMany(ReferralActivity::class, 'referrer_peace_id', 'peace_id');
    }
}
