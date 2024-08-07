<?php

namespace App\Http\Requests\Passenger;

use Illuminate\Foundation\Http\FormRequest;

class SearchFlightRequest extends FormRequest
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
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date',
            'passengers' => 'required|integer|min:1',
            'trip_type' => 'required|string|in:ONE_WAY,ROUND_TRIP,MULTI_DIRECTIONAL',
            'departure_airport' => 'required|string',
            'arrival_airport' => 'required|string',
            'passenger_type' => 'required|string',
        ];
    }
}
