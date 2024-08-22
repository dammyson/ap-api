<?php

namespace App\Http\Requests\Test\GetAvailability;

use Illuminate\Foundation\Http\FormRequest;

class GetAvailabilityRTRequest extends FormRequest
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
            "originDateOffsetOne" => "required|string", 
            "originDepartureDateTimeOne" => "required|string", 
            "originDestinationLocationCode" => "required|string",
            "flexibleFaresOnlyOne" => "required|boolean",
            "includeInterlineFlightsOne" => "required|boolean", 
            "openFlightOne" => "required|boolean",
            "originLocationCodeOne" => "required|string", 
            "originDataOffsetTwo" => "required|string", 
            "originDepartureDateTimeTwo" => "required|string",
            "destinationLocationCodeTwo" => "required|string", 
            "flexibleFaresOnlyTwo" => "required|boolean", 
            "includeInterlineFlightsTwo" => "required|boolean",
            "openFlightTwo" => "required|boolean", 
            "originLocationCodeTwo" => "required|string", 
            "travelerInformationCode" => "required|string", 
            "travelerQuantity" => "required|string",
            "tripType" => "required|string"
        ];
    }
}
