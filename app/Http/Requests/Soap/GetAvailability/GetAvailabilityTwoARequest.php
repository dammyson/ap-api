<?php

namespace App\Http\Requests\Soap\GetAvailability;

use Illuminate\Foundation\Http\FormRequest;

class GetAvailabilityTwoARequest extends FormRequest
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
            "dataOffset" => "required|string", 
            "departureDateTime" => "required|string", 
            "destinationLocationCode" => "required|string", 
            "flexibleFareOnly" => "required|string", 
            "includeInterlineFlights" => "required|string", 
            "openFlight" => "required|string", 
            "originLocationCode" => "required|string", 
            "adultPassengerTypeCode" => "required|string", 
            "adultQuantity" => "required|string",
            "childPassengerTypeCode" => "required|string", 
            "childQuantity" => "required|string", 
            "infantPassengerTypeCode" => "required|string",
            "infantQuantity" => "required|string", 
            "tripType" => "required|string"
        ];
    }
}
