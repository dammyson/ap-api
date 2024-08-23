<?php

namespace App\Http\Requests\Test\SegmentBase;

use Illuminate\Foundation\Http\FormRequest;

class SegmentBaseAvailableSpecialServicesRequest extends FormRequest
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
            "bookingClassCabin" => 'required|string',
            "bookingResBookDesigCode" => 'required|string',
            "bookingClassResBookDesigQuantity" => 'required|string',
            "bookingClassResBookDesigStatusCode" => 'required|string',
            "fareInfoCabin" => 'required|string',
            "fareInfoCabinClassCode" => 'required|string',
            "fareBaggageAllowanceType" => 'required|string',
            "fareBaggageMaxAllowedPieces" => 'required|string',
            "unitOfMeasureCode" => 'required|string',
            "weight" => 'required|string',
            "fareGroupName" => 'required|string',
            "fareReferenceCode" => 'required|string',
            "fareReferenceID" => 'required|string',
            "fareReferenceName" => 'required|string',
            "flightSegmentSequence" => 'required|string',
            "portTax" => 'required|string',
            "resBookDesigCode" => 'required|string',
            "airlineCode" => 'required|string',
            "airlineCompanyFullName" => 'required|string',
            "arrivalCityLocationCode" => 'required|string',
            "arrivalCityLocationName" => 'required|string',
            "arrivalCityLocationNameLanguage" => 'required|string',
            "arrivalCountryLocationCode" => 'required|string',
            "arrivalCountryLocationName" => 'required|string',
            "arrivalCountryLocationNameLanguage" => 'required|string',
            "arrivalCountryCurrencyCode" => 'required|string',
            "arrivalCodeContext" => 'required|string',
            "arrivalLanguage" => 'required|string',
            "arrivalLocationCode" => 'required|string',
            "arrivalLocationName" => 'required|string',
            "arrivalTimeZoneInfo" => 'required|string',
            "arrivalDateTime" => 'required|string',
            "arrivalDateTimeUTC" => 'required|string',
            "departureCityLocationCode" => 'required|string',
            "departureCityLocationName" => 'required|string',
            "departureCityLocationNameLanguage" => 'required|string',
            "departureCountryLocationCode" => 'required|string',
            "departureCountryLocationName" => 'required|string',
            "departureCountryLocationNameLanguage" => 'required|string',
            "departureCountryCurrencyCode" => 'required|string',
            "departureAirportCodeContext" => 'required|string',
            "departureAirportLanguage" => 'required|string',
            "departureAirportLocationCode" => 'required|string',
            "departureAirportLocationName" => 'required|string',
            "departureAirportTimeZoneInfo" => 'required|string',
            "departureDateTime" => 'required|string',
            "departureDateTimeUTC" => 'required|string',
            "flightNumber" => 'required|string',
            "flightSegmentID" => 'required|string',
            "ondControlled" => 'required|boolean',
            "sector" => 'required|string',
            "codeShare" => 'required|boolean',
            "distance" => 'required|string',
            "airEquipType" => 'required|string',
            "changeOfGauge" => 'required|string',
            "flightNotesDeiCodeOne" => 'required|string',
            "flightNotesExplanationOne" => 'required|string',
            "flightNotesNoteOne" => 'required|string',
            "flightNotesDeiCodeTwo" => 'required|string',
            "flightNotesExplanationTwo" => 'required|string',
            "flightNotesNoteTwo" => 'required|string',
            "flightNotesDeiCodeThree" => 'required|string',
            "flightNotesExplanationThree" => 'required|string',
            "flightNotesNoteThree" => 'required|string',
            "flownMileageQty" => 'required|string',
            "iatciFlight" => 'required|boolean',
            "journeyDuration" => 'required|string',
            "onTimeRate" => 'required|string',
            "remark" => 'required|string',
            "secureFlightDataRequired" => 'required|boolean',
            "stopQuantity" => 'required|string',
            "ticketType" => 'required|string'
        ];
    }
}
