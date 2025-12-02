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
            "bookingFlightSegmentList" => "required|array",
            "bookingFlightSegmentList.*.bookingClassCabin" => 'required|string',
            "bookingFlightSegmentList.*.bookingResBookDesigCode" => 'required|string',
            "bookingFlightSegmentList.*.bookingClassResBookDesigQuantity" => 'required|string',
            "bookingFlightSegmentList.*.bookingClassResBookDesigStatusCode" => 'required|string',
            "bookingFlightSegmentList.*.fareInfoCabin" => 'required|string',
            "bookingFlightSegmentList.*.fareInfoCabinClassCode" => 'required|string',
            "bookingFlightSegmentList.*.fareBaggageAllowanceType" => 'required|string',
            "bookingFlightSegmentList.*.fareBaggageMaxAllowedPieces" => 'required|string',
            "bookingFlightSegmentList.*.unitOfMeasureCode" => 'required|string',
            "bookingFlightSegmentList.*.weight" => 'required|string',
            "bookingFlightSegmentList.*.fareGroupName" => 'required|string',
            "bookingFlightSegmentList.*.fareReferenceCode" => 'required|string',
            "bookingFlightSegmentList.*.fareReferenceID" => 'required|string',
            "bookingFlightSegmentList.*.fareReferenceName" => 'required|string',
            "bookingFlightSegmentList.*.flightSegmentSequence" => 'required|string',
            "bookingFlightSegmentList.*.portTax" => 'required|string',
            "bookingFlightSegmentList.*.resBookDesigCode" => 'required|string',
            "bookingFlightSegmentList.*.airlineCode" => 'required|string',
            "bookingFlightSegmentList.*.airlineCompanyFullName" => 'required|string',
            "bookingFlightSegmentList.*.arrivalCityLocationCode" => 'required|string',
            "bookingFlightSegmentList.*.arrivalCityLocationName" => 'required|string',
            "bookingFlightSegmentList.*.arrivalCityLocationNameLanguage" => 'required|string',
            "bookingFlightSegmentList.*.arrivalCountryLocationCode" => 'required|string',
            "bookingFlightSegmentList.*.arrivalCountryLocationName" => 'required|string',
            "bookingFlightSegmentList.*.arrivalCountryLocationNameLanguage" => 'required|string',
            "bookingFlightSegmentList.*.arrivalCountryCurrencyCode" => 'required|string',
            "bookingFlightSegmentList.*.arrivalCodeContext" => 'required|string',
            "bookingFlightSegmentList.*.arrivalLanguage" => 'required|string',
            "bookingFlightSegmentList.*.arrivalLocationCode" => 'required|string',
            "bookingFlightSegmentList.*.arrivalLocationName" => 'required|string',
            "bookingFlightSegmentList.*.arrivalTimeZoneInfo" => 'required|string',
            "bookingFlightSegmentList.*.arrivalDateTime" => 'required|string',
            "bookingFlightSegmentList.*.arrivalDateTimeUTC" => 'required|string',
            "bookingFlightSegmentList.*.departureCityLocationCode" => 'required|string',
            "bookingFlightSegmentList.*.departureCityLocationName" => 'required|string',
            "bookingFlightSegmentList.*.departureCityLocationNameLanguage" => 'required|string',
            "bookingFlightSegmentList.*.departureCountryLocationCode" => 'required|string',
            "bookingFlightSegmentList.*.departureCountryLocationName" => 'required|string',
            "bookingFlightSegmentList.*.departureCountryLocationNameLanguage" => 'required|string',
            "bookingFlightSegmentList.*.departureCountryCurrencyCode" => 'required|string',
            "bookingFlightSegmentList.*.departureAirportCodeContext" => 'required|string',
            "bookingFlightSegmentList.*.departureAirportLanguage" => 'required|string',
            "bookingFlightSegmentList.*.departureAirportLocationCode" => 'required|string',
            "bookingFlightSegmentList.*.departureAirportLocationName" => 'required|string',
            "bookingFlightSegmentList.*.departureAirportTimeZoneInfo" => 'required|string',
            "bookingFlightSegmentList.*.departureDateTime" => 'required|string',
            "bookingFlightSegmentList.*.departureDateTimeUTC" => 'required|string',
            "bookingFlightSegmentList.*.flightNumber" => 'required|string',
            "bookingFlightSegmentList.*.flightSegmentID" => 'required|string',
            "bookingFlightSegmentList.*.ondControlled" => 'required|boolean',
            "bookingFlightSegmentList.*.sector" => 'required|string',
            "bookingFlightSegmentList.*.codeShare" => 'required|boolean',
            "bookingFlightSegmentList.*.distance" => 'required|string',
            "bookingFlightSegmentList.*.airEquipType" => 'required|string',
            "bookingFlightSegmentList.*.changeOfGauge" => 'required|string',

            'bookingFlightSegmentList.*.flightNotes' => 'required|array',
            'bookingFlightSegmentList.*.flightNotes.*.deiCode' => 'required|string',
            'bookingFlightSegmentList.*.flightNotes.*.explanation' => 'required|string',
            'bookingFlightSegmentList.*.flightNotes.*.note' => 'required|string',


            "bookingFlightSegmentList.*.flownMileageQty" => 'required|string',
            "bookingFlightSegmentList.*.iatciFlight" => 'required|boolean',
            "bookingFlightSegmentList.*.journeyDuration" => 'required|string',
            "bookingFlightSegmentList.*.onTimeRate" => 'required|string',
            "bookingFlightSegmentList.*.remark" => 'sometimes',
            "bookingFlightSegmentList.*.secureFlightDataRequired" => 'required|boolean',
            "bookingFlightSegmentList.*.stopQuantity" => 'required|string',
            "bookingFlightSegmentList.*.ticketType" => 'required|string',
            "ssrGroupCode" => 'sometimes'
        ];
    }
}
