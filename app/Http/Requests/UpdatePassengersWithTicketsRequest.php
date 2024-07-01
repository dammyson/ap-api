<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassengersWithTicketsRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Change this if you have authorization logic
    }

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