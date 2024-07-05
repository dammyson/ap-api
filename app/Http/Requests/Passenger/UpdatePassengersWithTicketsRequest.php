<?php

namespace App\Http\Requests\Passenger;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassengersWithTicketsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Change this if you have authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'passengers' => 'required|array',
            'passengers.*.id' => 'required|integer',
            'passengers.*.tickets.*.seat_number' => 'required|string|max:255',
            'passengers.*.tickets.*.ticket_type_id' => 'required|exists:flight_ticket_types,id',
        ];
        return $rules;
    }
}
