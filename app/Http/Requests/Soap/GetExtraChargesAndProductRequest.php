<?php

namespace App\Http\Requests\Soap;

use Illuminate\Foundation\Http\FormRequest;

class GetExtraChargesAndProductRequest extends FormRequest
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
            "preferredCurrency" => "required|string",
            "bookFlightSegmentList" => "required|array",
            "bookFlightSegmentList.*.bookingClassCabin" => "required|string", 
            "bookFlightSegmentList.*.bookingClassResBookDesigCode" => "required|string", 
            "bookFlightSegmentList.*.bookingClassResBookDesigQuantity" => "required|string", 
            "bookFlightSegmentList.*.bookingClassResBookDesigStatusCode" => "required|string",
            "bookFlightSegmentList.*.fareInfoCabin" => "required|string", 
            "bookFlightSegmentList.*.fareInfoCabinClassCode" => "required|string", 
            "bookFlightSegmentList.*.fareBaggageAllowanceType" => "required|string", 
            "bookFlightSegmentList.*.fareBaggageMaxAllowedPieces" => "required|string",
            "bookFlightSegmentList.*.unitOfMeasureCode" => "required|string", 
            "bookFlightSegmentList.*.weight" => "required|string",
            "bookFlightSegmentList.*.fareGroupName" => "required|string", 
            "bookFlightSegmentList.*.fareReferenceCode" => "required|string", 
            "bookFlightSegmentList.*.fareReferenceID" => "required|string", 
            "bookFlightSegmentList.*.fareReferenceName" => "required|string", 
            "bookFlightSegmentList.*.flightSegmentSequence" => "required|string",
            "bookFlightSegmentList.*.portTax" => "required|string", 
            "bookFlightSegmentList.*.resBookDesigCode" => "required|string",
            // "bookFlightSegmentList.*.airlineCode" => "required|string", 
            // "bookFlightSegmentList.*.companyFullName" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportCityLocationCode" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportCityLocationName" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportCityLocationNameLanguage" => "required|string",
            "bookFlightSegmentList.*.arrivalAirportCountryLocationCode" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportCountryLocationName" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportCountryLocationNameLangauge" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportCountryCurrencyCode" => "required|string",
            "bookFlightSegmentList.*.arrivalAirportCodeContext" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportLanguage" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportLocationCode" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportLocationName" => "required|string", 
            "bookFlightSegmentList.*.arrivalAirportTimeZoneInfo" => "required|string",
            "bookFlightSegmentList.*.arrivalDateTime" => "required|string", 
            "bookFlightSegmentList.*.arrivalDateTimeUTC" => "required|string", 
            "bookFlightSegmentList.*.departureAirportCitytLocationCode" => "required|string", 
            "bookFlightSegmentList.*.departureAirportCityLocationName" => "required|string", 
            "bookFlightSegmentList.*.departureAirportCityLocationNameLanguage" => "required|string",
            "bookFlightSegmentList.*.departureAirportCountrytLocationCode" => "required|string", 
            "bookFlightSegmentList.*.departureAirportCountryLocationName" => "required|string", 
            "bookFlightSegmentList.*.departureAirportCountryLocationNameLanguage" => "required|string", 
            "bookFlightSegmentList.*.departureAirportCountyCurrencyCode" => "required|string",
            "bookFlightSegmentList.*.departureAirportCodeContext" => "required|string", 
            "bookFlightSegmentList.*.departureAirportLanguage" => "required|string", 
            "bookFlightSegmentList.*.departureAirportLocationCode" => "required|string", 
            "bookFlightSegmentList.*.departureAirportLocationName" => "required|string", 
            "bookFlightSegmentList.*.departureAirportTimeZoneInfo" => "required|string",
            "bookFlightSegmentList.*.departureDateTime" => "required|string", 
            "bookFlightSegmentList.*.departureDateTimeUTC" => "required|string", 
            "bookFlightSegmentList.*.flightNumber" => "required|string", 
            "bookFlightSegmentList.*.flightSegmentID" => "required|string", 
            "bookFlightSegmentList.*.ondControlled" => "required|string", 
            "bookFlightSegmentList.*.sector" => "required|string", 
            "bookFlightSegmentList.*.codeShare" => "required|string", 
            "bookFlightSegmentList.*.distance" => "required|string",
            "bookFlightSegmentList.*.airEquipType" => "required|string", 
            "bookFlightSegmentList.*.changeOfGuage" => "required|string", 
            "bookFlightSegmentList.*.flightNotes" => 'required|array',
            "bookFlightSegmentList.*.flightNotes.*.deiCode" => "required|string",
            "bookFlightSegmentList.*.flightNotes.*.explanation" => "required|string",
            "bookFlightSegmentList.*.flightNotes.*.note" => "required|string",
            "bookFlightSegmentList.*.flownMileageQty" => "required|string", 
            "bookFlightSegmentList.*.iatciFlight" => "required|string", 
            "bookFlightSegmentList.*.journeyDuration" => "required|string", 
            "bookFlightSegmentList.*.onTimeRate" => "required|string", 
            "bookFlightSegmentList.*.remark" => "nullable|string", 
            "bookFlightSegmentList.*.secureFlightDataRequired" => "required|string", 
            "bookFlightSegmentList.*.stopQuantity" => "required|string", 
            "bookFlightSegmentList.*.ticketType" => "required|string",
            
            "locationCode" => "required|string", 
           
            "passengerTypeQuantityList" => "required|array", 
            "passengerTypeQuantityList.*.passengerTypeCode" => "required|string", 
            "passengerTypeQuantityList.*.quantity" => "required|string",  
            "tripType" => "required|string", 
        ];
    }
}
