<?php

namespace App\Http\Requests\Reissue;

use Illuminate\Foundation\Http\FormRequest;

class ReissuePnrPreviewRequest extends FormRequest
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
            "ID" => "required|string", 
            "referenceID" => "required|string", 
            "bookingClassCabinOne" => "required|string", 
            "bookingClassResBookDesigCodeOne" => "required|string", 
            "bookingClassResBookDesigQuantityOne" => "required|string", 
            "bookignClassResBookDesigStatusCodeOne" => "required|string", 
            "fareInfoCabinOne" => "required|string", 
            "fareInfocabinClassCodeOne" => "required|string",
            "fareInfoCabinAllowanceTypeOne" => "required|string",
            "maxAllowedPiecesOne" => "required|string",
            "unitOfMeasureCodeOne" => "required|string",
            "weightOne" => "required|string",
            "fareGroupNameOne" => "required|string",
            "fareReferenceCodeOne" => "required|string",
            "fareReferenceIDOne" => "required|string",
            "fareReferenceNameOne" => "required|string",
            "flightSegmentSequenceOne" => "required|string",
            "portTaxOne" => "required|string",
            "resBookDesigCodeOne" => "required|string",
            "airlineCodeOne" => "required|string",
            "airlinecompanyFullNameOne" => "required|string",
            "arrivalAirportCityLocationCodeOne" => "required|string",
            "arrivalAirportCityLocationNameOne" => "required|string",
            "arrivalAirportLocationNameLanguageOne" => "required|string",
            "arrivalAirportCountryLocationCodeOne" => "required|string",
            "arrivalAirportCountryLocationNameOne" => "required|string",
            "arrivalAirportCountryLocationNameLanguageOne" => "required|string",
            "arrivalAirportCountryCurrencyCodeOne" => "required|string",
            "arrivalAirportCodeContextOne" => "required|string",
            "arrivalAirportLanguageOne" => "required|string",
            "arrivalAirportLocationCodeOne" => "required|string",
            "arrivalAirportLocationNameOne" => "required|string",
            "arrivalAirportTimeZoneInfoOne" => "required|string",
            "arrivalDateTimeOne" => "required|string",
            "arrivalDateTimeUTCOne" => "required|string",
            "departureAirportCityLocationCodeOne" => "required|string",
            "departureAirportCityLocationNameOne" => "required|string",
            "departureAirportCityLocationNameLanguage" => "required|string",
            "departureAirportCountryLocationCodeOne" => "required|string",
            "departureAirportCountryLocationNameOne" => "required|string",
            "departureAirportCountryLocationNameLanguageOne" => "required|string",
            "departureAirportCountryCodeOne" => "required|string",
            "departureAirportCodeContextOne" => "required|string",
            "departureAirportLanguageOne" => "required|string",
            "departureAirportLocationCodeOne" => "required|string",
            "departureAirportLocationNameOne" => "required|string",
            "departureTimeZoneInfoOne" => "required|string",
            "departureDateTimeOne" => "required|string",
            "departureDateTimeUTCOne" => "required|string",
            "flightNumberOne" => "required|string",
            "flightSegmentIDOne" => "required|string",
            "ondControlledOne" => "required|string",
            "sectorOne" => "required|string",
            "codeShareOne" => "required|string",
            "distanceOne" => "required|string",
            "equipmentAirEquipTypeOne" => "required|string",
            "equipmentChangeOfGaugeOne" => "required|string",
            "flightNotesOne" => "required|array",
            "flownMileageQtyOne" => "required|string",
            "iatciFlightOne" => "required|string",
            "journeyDurationOne" => "required|string",
            "onTimeRateOne" => "required|string",
            "remarkOne" => "required|string",
            "secureFlightDataRequiredOne" => "required|string",
            "stopQuantityOne" => "required|string",
            "ticketTypeOne" => "required|string",
            "actionCodeTwo" => "required|string",
            "addOnSegmentTwo" => "required|string",
            "bookingClassCabinTwo" => "required|string",
            "bookingCabinResBookDesigCodeTwo" => "required|string",
            "bookingCabinResBookDesigQuantityTwo" => "required|string",
            "fareInfoCabinTwo" => "required|string",
            "fareInfoCabinClassCodeTwo" => "required|string",
            "allowanceTypeTwo" => "required|string",
            "maxAllowedPiecesTwo" => "required|string",
            "unitOfMeasureCodeTwo" => "required|string",
            "weightTwo" => "required|string",
            "fareGroupNameTwo" => "required|string",
            "fareReferenceCodeTwo" => "required|string",
            "fareReferenceIDTwo" => "required|string",
            "fareReferenceNameTwo" => "required|string",
            "flightSegmentSequenceTwo" => "required|string",
            "resBookDesigCodeTwo" => "required|string",
            "airlineCodeTwo" => "required|string",
            "airlineCodeContextTwo" => "required|string",
            "arrivalAirportCityLocationCodeTwo" => "required|string",
            "arrivalAirportCityLocationNameTwo" => "required|string",
            "arrivalAirportCityLocationNameLanguageTwo" => "required|string",
            "arrivalAirportCountryLocationCodeTwo" => "required|string",
            "arrivalAirportCountryLocationNameTwo" => "required|string",
            "arrivalAirportLocationNameLanguageTwo" => "required|string",
            "arrivalAirportCountryCodeTwo" => "required|string",
            "arrivalAirportCodeContextTwo" => "required|string",
            "arrivalAirportLanguageTwo" => "required|string",
            "arrivalAirportLocationCodeTwo" => "required|string",
            "arrivalAirportLocationNameTwo" => "required|string",
            "arrivalAirportTerminalTwo" => "required|string",
            "arrivalAirportTimeZoneInfoTwo" => "required|string",
            "arrivalDateTimeTwo" => "required|string",
            "arrivalDateTimeUTCTwo" => "required|string",
            "departureAirportCityLocationCodeTwo" => "required|string",
            "departureAirportCityLocationNameTwo" => "required|string",
            "departureAirportCityLocationNameLanguageTwo" => "required|string",
            "departureAirportCountryLocationCodeTwo" => "required|string",
            "departureAirportCountryLocationNameTwo" => "required|string",
            "departureAirportLocationNameLanguageTwo" => "required|string",
            "departureAirportCountryCurrencyCodeTwo" => "required|string",
            "departureAirportCodeContextTwo" => "required|string",
            "departureAirportLanguageTwo" => "required|string",
            "departureAirportLocationCodeTwo" => "required|string",
            "departureAirportLocationNameTwo" => "required|string",
            "departureAirportTimeZoneInfoTwo" => "required|string",
            "departureDateTimeTwo" => "required|string",
            "departureDateTimeUTCTwo" => "required|string",
            "flightNumberTwo" => "required|string",
            "flightSegmentIDTwo" => "required|string",
            "ondControlledTwo" => "required|string",
            "sectorTwo" => "required|string",
            "codeShareTwo" => "required|string",
            "distanceTwo" => "required|string",
            "equipmentAirEquipTypeTwo" => "required|string",
            "equipmentChangeOfGaugeTwo" => "required|string",
            "flightNotesTwo" => "required|array",
            "flownMileageQtyTwo" => "required|string",
            "iatciFlightTwo" => "required|string",
            "journeyDurationTwo" => "required|string",
            "onTimeRateTwo" => "required|string",
            "remarkTwo" => "required|string",
            "secureFlightDataRequiredTwo" => "required|string",
            "segmentStatusByFirstLegTwo" => "required|string",
            "stopQuantityTwo" => "required|string",
            "involuntaryPermissionGivenTwo" => "required|string",
            "legStatusTwo" => "required|string",
            "referenceIDTwo" => "required|string",
            "responseCodeTwo" => "required|string",
            "sequenceNumberTwo" => "required|string",
            "statusTwo" => "required|string"
        ];
    }
}