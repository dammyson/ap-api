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
            'email' => 'required|email|unique:users,email',
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
            'screen_resolution' => 'sometimes|string',
            "firebase_token" => "nullable|string"
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'Email has already been taken.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.numeric' => 'Phone number must contain only numbers.',
            'phone_number.digits' => 'Phone number must be exactly 11 digits.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter, one number, and one special character.',
            'password.confirmed' => 'Password confirmation does not match.',
            'peace_id.required' => 'Peace ID is required.',
            'peace_id.unique' => 'Peace ID is already taken.',
            'referrer_peace_id.exists' => 'Referrer Peace ID does not exist.',
        ];
    }

}
