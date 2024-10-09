<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['survey_id', 'question_text', 'is_multiple_choice'];

    public function survey() {
      return $this->belongsTo(Survey::class);
    }
    
    public function options() {
        return $this->hasMany(Option::class);
    }

   
}
