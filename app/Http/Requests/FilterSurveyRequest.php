<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterSurveyRequest extends FormRequest
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
            'title' => 'sometimes|string',
            'from_date' => 'sometimes|date',
            'to_date' => 'sometimes|date|gte:from_date'
        ];
    }

    /**
     * Get the custom error messages for validation rules.
     *
     * @return array<string, string>
    */
    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'from_date.date' => 'The from date must be a valid date.',
            'to_date.date' => 'The to date must be a valid date.',
            'to_date.gte' => 'The to date must be equal to or after the from date.',
        ];
    }
}
