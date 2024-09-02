<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            "image_url" => "sometimes|string",
            "title" => "sometimes|string",
            "first_name" => "sometimes|string",
            "last_name" => "sometimes|string",
            "nationality" => "sometimes|string",
            "date_of_birth" => "sometimes|date",
            "email" => "sometimes|email",
            "phone_number" => "sometimes|string",
            "travel_document" => "sometimes|file|mimes:pdf,jpg,png|max:2048"
        ];
    }
}
