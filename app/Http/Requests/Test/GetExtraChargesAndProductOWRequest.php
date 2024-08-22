<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class GetExtraChargesAndProductOWRequest extends FormRequest
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
            "bookingClassCabin" => "required|string",
            "bookingClassResBookDesigCode" => "required|string",
            "bookingClassResBookDesigQuantity" => "required|string",
            "bookingClassResBookDesigStatusCode" => "required|string",
            "fareInfoCabin" => "required|string",
            "fareInfoCabinClassCode" => "required|string",
            "fareBaggageAllowanceType" => "required|string",
            "fareBaggageAllowanceMaxAllowedPieces" => "required|string",
            "unitOfMeasureCode" => "required|string",
            "weight" => "required|string",
            "fareGroupName" => "required|string",
            "fareReferenceCode" => "required|string",
            "fareReferenceID" => "required|string",
            "fareReferenceName" => "required|string",
            "flightSegmentSequence" => "required|string",
            "portTax" => "required|string",
            "resBookDesigCode" => "required|string",
            "airlineCode" => "required|string",
            "companyFullName" => "required|string",
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
            "arrivalAirportTimeZoneInfo" => "required|string",
            "arrivalDateTimeUTC" => "required|string",
            "departureAirportCityLocationCode" => "required|string",
            "departureAirportCityLocationName" => "required|string",
            "departureAirportCityLocationNameLanguage" => "required|string",
            "departureAirportCountryLocationCode" => "required|string",
            "departureAirportCountryLocationName" => "required|string",
            "departureAirportCountryNameLanguage" => "required|string",
            "departureAirportCountryCurrencyCode" => "required|string",
            "departureAirportCodeContext" => "required|string",
            "departureAirportLanguage" => "required|string",
            "departureAirportLocationCode" => "required|string",
            "departureAirportLocationName" => "required|string",
            "departureAiportTimeZoneInfo" => "required|string",
            "departureDateTime" => "required|string",
            "departureDateTimeUTC" => "required|string",
            "flightNumber" => "required|string",
            "flightSegmentID" => "required|string",
            "ondControlled" => "required|boolean",
            "sector" => "required|string",
            "codeShare" => "required|boolean",
            "distance" => "required|string",
            "airEquipType" => "required|string",
            "changeOfGuage" => "required|boolean",
            "flightNotesDeiCodeOne" => "required|string",
            "flightExplanationOne" => "required|string",
            "flightNotesNoteOne" => "required|string",
            "flightNotesDeiCodeTwo" => "required|string",
            "flightNotesExplanationTwo" => "required|string",
            "flightNotesNoteTwo" => "required|string",
            "flightNotesDeiCodeThree" => "required|string",
            "flightNotesExplanationThree" => "required|string",
            "flightNotesNoteThree" => "required|string",
            "flownMileageQty" => "required|string",
            "iatciFlight" => "required|boolean",
            "journeyDuration" => "required|string",
            "onTimeRate" => "required|string",
            "remark" => "required|string",
            "secureFlightDataRequired" => "required|boolean",
            "stopQuantity" => "required|string",
            "ticketType" => "required|string",
            "locationCode" => "required|string",
            "passengerTypeCode" => "required|string", 
            "quantity" => "required|string",
            "tripType" => "required|string",
        ];
    }
}
