<?php

namespace App\Http\Requests\Test\Booking;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingOWRequest extends FormRequest
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
            "actionCode" => "required|string",
            "bookingClassCabin" => "required|string",
            "bookingClassResBookDesigCode" => "required|string",
            "bookingClassResBookDesigQuantity" => "required|string",
            "bookingClassResBookDesigStatusCode" => "required|string",
            "fareInfoCabin" => "required|string",
            "fareInfoCabinClassCode" => "required|string",
            "fareBaggageAllowanceType" => "required|string",
            "fareBaggageMaxAllowedPieces" => "required|string",
            "unitOfMeasureCode" => "required|string",
            "maxAllowedWeight" => "required|string",
            "fareGroupName" => "required|string",
            "fareReferenceCode" => "required|string",
            "fareReferenceID" => "required|string",
            "fareReferenceName" => "required|string",
            "flightSegmeneSequence" => "required|string",
            "fareInfoPortTax" => "required|string",
            "fareInfoResBookDesigCode" => "required|string",
            "airlineCode" => "required|string",
            "airlineCompanyFullName" => "required|string",
            "arrivalAirportCityLocationCode" => "required|string",
            "arrivalAirportCityLocationName" => "required|string",
            "arrivalAirportCityLocationNameLanguage" => "required|string",
            "arrivalAirportCountryLocationCode" => "required|string",
            "arrivalAirportCountryLocationName" => "required|string",
            "arrivalAirportCountryLocationNameLanguage" => "required|string",
            "arrivalAirportCountryCode" => "required|string",
            "arrivalAirportCodeContext" => "required|string",
            "arrivalAirportLanguage" => "required|string",
            "arrivalAirportLocationCode" => "required|string",
            "arrivalAirportLocationName" => "required|string",
            "arrivalAirportTimeZoneInfo" => "required|string",
            "arrivalDateTime" => "required|string",
            "arrivalDateTimeUTC" => "required|string",
            "departureAirportCityLocationCode" => "required|string",
            "departureAirportCityLocationName" => "required|string",
            "departureAirportCityLocationNameLanguage" => "required|string",
            "departureAirportCountryLocationCode" => "required|string",
            "departureAirportCountryLocationName" => "required|string",
            "departureAirportCountryLocationNameLanguage" => "required|string",
            "departureAirportCountryCurrencyCode" => "required|string",
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
            "flightNoteOne" => "required|string",
            "flightNotesDeiCodeTwo" => "required|string",
            "flightNotesExplanationTwo" => "required|string",
            "flightNotesNoteTwo" => "required|string",
            "flightNoteDeiCodeThree" => "required|string",
            "flightNoteExplanationThree" => "required|string",
            "flightNotesNoteThree" => "required|string",
            "flownMileageQty" => "required|string",
            "iatciFlight" => "required|boolean",
            "journeyDuration" => "required|string",
            "onTimeRate" => "required|string",
            "remark" => "required|string",
            "secureFlightDataRequired" => "required|boolean",
            "stopQuantity" => "required|string",
            "ticketType" => "required|string",
            "airTravelerListGender" => "required|string",
            "airTravelerPassengerTypeCode" => "required|string",
            "airTravelerListGivenName" => "required|string",
            "airTravelerListSurname" => "required|string",
            "airTravelerBirthDate" => "required|string",
            "contactPersonEmail" => "required|string",
            "contactPersonShareMarketInd" => "required|boolean",
            "contactPersonMarkedForSendingRezInfo" => "required|boolean",
            "contactPersonNameGivenName" => "required|string",
            "contactPersonSurname" => "required|string",
            "phoneNumberAreaCode" => "required|string",
            "phoneNumberCountryCode" => "required|string",
            "phoneNumberMarkedForSendingRezInfo" => "required|boolean",
            "phoneNumberSubscriberNumber" => "required|string",
            "shareMarketInd" => "required|boolean",
            "contactPersonSocialSecurityNumber" => "required|string",
            "shareContactInfo" => "required|boolean",
            "requestedSeatCount" => "required|string",
            "requestPurpose" => "required|string"
        ];
    }
}
