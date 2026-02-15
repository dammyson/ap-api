<?php

namespace App\Http\Requests\Support;

use Illuminate\Foundation\Http\FormRequest;

class ContactSupportRequest extends FormRequest
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
            'email' => 'required|email|max:255',
            'booking_reference' => 'sometimes|string',
            'name_on_ticket' => 'sometimes|string',
            'date_of_occurence' => 'sometimes|date',
            'description' => 'sometimes|string',
            'category' => 'sometimes|in:refund,reversal,other'
        ];
    }
}
