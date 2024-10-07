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

            'trip_type' => 'required|string|in:ONE_WAY,ROUND_TRIP,MULTI_DIRECTIONAL',

            'departure_date' => 'required_if:trip_type,ONE_WAY,ROUND_TRIP|date',
            'arrival_date' => 'required_if:trip_type,ROUND_TRIP|date|after:departure_date',
           
            'departure_airport' => 'required_if:trip_type,ONE_WAY,ROUND_TRIP|string',
            'arrival_airport' => 'required_if:trip_type,ONE_WAY,ROUND_TRIP|string',

            // Validation for MULTI_DIRECTIONAL
            'multi_directional_flights' => 'required_if:trip_type,MULTI_DIRECTIONAL|array',
            'multi_directional_flights.*.departure_airport' => 'required_if:trip_type,MULTI_DIRECTIONAL|string|size:3',
            'multi_directional_flights.*.departure_date' => 'required_if:trip_type,MULTI_DIRECTIONAL|date',
            'multi_directional_flights.*.arrival_airport' => 'required_if:trip_type,MULTI_DIRECTIONAL|string|size:3',

            'travelerInformation' => 'required|array',
            'travelerInformation.*.passenger_type' => 'required|string',
            'travelerInformation.*.passengers' => 'required|integer|min:1',
        ];
    }
}
