<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassengersWithTicketsRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you have authorization logic
    }

    public function rules()
    {
        $passengers = $this->input('passengers');

        // Base validation rules
        $rules = [
            'passengers' => 'required|array',
            'passengers.*.title' => 'required|string|max:255',
            'passengers.*.first_name' => 'required|string|max:255',
            'passengers.*.last_name' => 'required|string|max:255',
            'passengers.*.date_of_birth' => 'required|date',
            'passengers.*.sex' => 'required|string|max:255',
            'passengers.*.country' => 'required|string|max:255',
            'passengers.*.passport_number' => 'nullable|string|max:255',
            'passengers.*.is_blind' => 'required|boolean',
            'passengers.*.is_deaf' => 'required|boolean',
            'passengers.*.needs_mobility_assistance' => 'required|boolean',
            'passengers.*.is_contact_person' => 'required|boolean',
            'passengers.*.invoice_type' => 'required|string|in:personal,company',
            'passengers.*.user_category' => 'required|string|in:Adult,Child',
            'passengers.*.tickets' => 'required|array',
            'passengers.*.tickets.*.flight_id' => 'required|exists:flights,id',
            'passengers.*.tickets.*.seat_number' => 'required|string|max:255',
            'passengers.*.tickets.*.status' => 'required|integer|in:0,1,2',
            'passengers.*.tickets.*.ticket_type_id' => 'required|exists:flight_ticket_types,id', // Add this line
        ];

        // Additional rules for adults
        foreach ($passengers as $index => $passenger) {
            if (isset($passenger['user_category']) && $passenger['user_category'] === 'Adult') {
                $rules["passengers.$index.phone_number"] = 'required|string|max:255';
                $rules["passengers.$index.email"] = 'required|email';
            } else {
                $rules["passengers.$index.email"] = 'nullable|email';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'passengers.*.phone_number.required' => 'The phone number is required for adult passengers.',
            'passengers.*.email.required' => 'The email is required for adult passengers.',
        ];
    }
}