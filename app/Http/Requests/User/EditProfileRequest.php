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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "image_url" => "required|string",
            "title" => "required|string",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "nationality" => "required|string",
            "date_of_birth" => "required|date",
            "email" => "required|email",
            "phone_number" => "required|string",
            "travel_document" => "required|string"
        ];
    }
}
