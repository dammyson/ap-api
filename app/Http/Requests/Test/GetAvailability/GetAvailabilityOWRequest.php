<?php

namespace App\Http\Requests\Test\GetAvailability;

use Illuminate\Foundation\Http\FormRequest;

class GetAvailabilityOWRequest extends FormRequest
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
            "originDateOffset" => "required|string", 
            "departureDateTime" => "required|string", 
            "destinationLocationCode" => "required|string",
            "flexibleFareOnly" => "required|boolean", 
            "includeInterlineFlights" => "required|boolean", 
            "openFlight" => "required|boolean",
            "originLocationCode" => "required|string", 
            "passengerTypeCode" => "required|string", 
            "passengerQuantity" => "required|string", 
            "tripType" => "required|string",
        ];
    }
}
