<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyUserResponse extends Model
{
    use HasFactory;
    protected $fillable = ['survey_id', 'question_id', 'user_id'];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    // Many-to-many relationship with Option
    public function options() {
        return $this->belongsToMany(Option::class, 'survey_user_response_option', 'survey_user_response_id', 'option_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
