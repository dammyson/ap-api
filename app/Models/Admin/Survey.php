<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'duration_of_survey', 'image_url', 'points_awarded', 'is_active', 'is_published', 'end_time', 'is_completed'];

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function SurveyUserResponse() {
        return $this->hasMany(SurveyUserResponse::class);
    }

    public function getIsExpiredAttribute()
    {
        $expirationTime = $this->updated_at->addMinutes($this->duration_of_survey);
        return now()->greaterThanOrEqualTo($expirationTime);
    }
}
