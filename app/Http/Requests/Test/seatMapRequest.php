<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class seatMapRequest extends FormRequest
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
            "airlineCode" => "required|string", 
            "airlineCodeContext" => "required|string",
            "arrivalAirportCityLocationCode" => "required|string",
            "arrivalAirportCityLocationName" => "required|string", 
            "arrivalAirportCityLocationNameLanguage" => "required|string",
            "arrivalAirportCountryLocationCode" => "required|string", 
            "arrivalAirportCountryLocationName" => "required|string", 
            "arrivalAirportCountryLocationNameLanguage" => "required|string", 
            "arrivalAirportCountryCurrencyCode" => "required|string",
            "arrivalAirportCodeContext" => "required|string", 
            "arrivalAirportLanguage" => "required|string", 
            "arrivalAirportLocationCode" => "required|string", 
            "arrivalAirportLocationName" => "required|string", 
            "arrivalAirportTerminal" => "required|string", 
            "arrivalAirportTimeZoneInfo" => "required|string",
            "arrivalAirportDateTime" => "required|string", 
            "arrivalAirportDateTimeUTC" => "required|string",
            "departureAirportCityLocationCode" => "required|string", 
            "departureAirportCityLocationName" => "required|string", 
            "departureAirportCityLocationNameLanguage" => "required|string",
            "departureAirportCountryLocationCode" => "required|string", 
            "departureAirportCountryLocationName" => "required|string", 
            "departureAirportLocationNameLanguage" => "required|string", 
            "departureAirportCurrencyCode" => "required|string",
            "departureAirportCodeContext" => "required|string", 
            "departureAirportLanguage" => "required|string", 
            "departureAirportLocationCode" => "required|string", 
            "departureAirportLocationName" => "required|string", 
            "departureAirportTimeZoneInfo" => "required|string",
            "departureDateTime" => "required|string", 
            "departureDateTimeUTC" => "required|string", 
            "flightNumber" => "required|string", 
            "flightSegmentID" => "required|string", 
            "ondControlled" => "required|boolean", 
            "sector" => "required|string",
            "codeshare" => "required|boolean", 
            "distance" => "required|string", 
            "airEquipType" => "required|string", 
            "changeOfGuage" => "required|boolean",
            "flightNotesDeiCodeOne" => "required|string", 
            "flightNotesExplanationOne" => "required|string", 
            "flightNotesNoteOne" => "required|string",
            "flightNotesDeiCodeTwo" => "required|string", 
            "flightNotesExplanationTwo" => "required|string", 
            "flightNotesNoteTwo" => "required|string",
            "flightNotesDeiCodeThree"=> "required|string", 
            "flightNotesExplanationThree"=> "required|string", 
            "flightNotesNoteThree"=> "required|string",
            "flownMileageQty"=> "required|string", 
            "iatciFlight"=> "required|boolean", 
            "journeyDuration"=> "required|string", 
            "onTimeRate"=> "required|string", 
            "remark" => "required|string", 
            "secureFlightDataRequired"=> "required|boolean",
            "segmentStatusByFirstLeg"=> "required|string", 
            "stopQuantity"=> "required|string", 
            "companyNameCitycode"=> "required|string", 
            "companyNameCode" => "required|string", 
            "companyNameCodeContext"=> "required|string",
            "companyFullName"=> "required|string", 
            "companyShortName"=> "required|string", 
            "countryCode"=> "required|string", 
            "ID"=> "required|string", 
            "referenceID" => "required|string"
        ];
    }
}
