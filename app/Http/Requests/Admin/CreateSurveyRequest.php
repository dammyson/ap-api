<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
      
        return [
            'title' => 'required|string',
            'duration_of_survey' => 'required|integer',
            'points_awarded' => 'sometimes|integer|min:0',
            "image_url" => "sometimes|file|mimes:jpg,png|max:2048", // Treat image_url as a file
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.is_multiple_choice' => 'required|boolean',
            'questions.*.options' => 'required|array',
            'questions.*.options.*.option_text' => 'required|string',
            'is_active' => "required|boolean",

        ];
    }
}
