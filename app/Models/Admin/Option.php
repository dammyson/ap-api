<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $fillable = ['question_id', 'option_text'];

    public function question() {
        return $this->belongsTo(Question::class);
    }

    // Many-to-many relationship with SurveyUserResponse
    public function surveyUserResponses() {
        return $this->belongsToMany(SurveyUserResponse::class, 'survey_user_response_option', 'option_id', 'survey_user_response_id');
    }

    
}
