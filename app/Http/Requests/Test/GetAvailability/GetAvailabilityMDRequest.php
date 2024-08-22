<?php

namespace App\Http\Requests\Test\GetAvailability;

use Illuminate\Foundation\Http\FormRequest;

class GetAvailabilityMDRequest extends FormRequest
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
            "originDataOffsetOne" => "required|string", 
            "departureDateTimeOne" => "required|string",
            "destinationLocationCodeOne" => "required|string",
            "flexibleFareOnlyOne" => "required|boolean", 
            "includeInterlineFlightsOne" => "required|boolean", 
            "openFlightOne" => "required|boolean",
            "originLocationCodeOne" => "required|string", 
            "originDataOffsetTwo" => "required|string", 
            "departureDateTimeTwo" => "required|string", 
            "destinationLocationCodeTwo" => "required|string",
            "flexibleFareOnlyTwo" => "required|boolean", 
            "includeInterlineFlightsTwo" => "required|boolean", 
            "openFlightTwo" => "required|boolean",
            "originLocationCodeTwo" => "required|string", 
            "passengerTypeCode" => "required|string", 
            "passengerQuantity" => "required|string",
            "tripType" => "required|string"
        ];
    }
}
