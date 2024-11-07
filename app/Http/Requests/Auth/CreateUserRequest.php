<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|numeric|digits:11',
            'password' => [
                'required',
                'string',
                'min:6', // At least six characters
                'regex:/[A-Z]/', // Must contain at least one uppercase letter
                'regex:/[0-9]/', // Must contain at least one number
                'regex:/[@$_!%*#?&]/', // Must contain at least one special character
                'confirmed', // Must match password confirmation
            ],
            'status' => 'sometimes|string',
            'peace_id' => 'required|unique:users,peace_id',           
            "referrer_peace_id" => 'sometimes|exists:users,peace_id',
            "device_type" => 'sometimes|string',            
            'screen_resolution' => 'sometimes|string'
        ];
    }
}
