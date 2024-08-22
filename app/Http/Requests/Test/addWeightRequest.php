<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class addWeightRequest extends FormRequest
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
            "adviceCodeSegmentExist" => "required|boolean",
            "bookFlightSegmentListActionCode" => "required|string",
            "bookFlightAddOnSegment" => "required|boolean",
            "bookingClassCabin" => "required|string",
            "bookingClassResBookDesigCode" => "required|string",
            "resBookDesignQuantity" => "required|string",
            "fareInfoCabin" => "required|string",
            "fareInfoCabinClassCode" => "required|string",
            "fareBaggageAllowanceType" => "required|string",
            "fareBaggageMaxAllowedPieces" => "required|string",
            "unitOfMeasureCode" => "required|string",
            "fareBaggageAllowanceWeight" => "required|string",
            "fareGroupName" => "required|string",
            "fareReferenceCode" => "required|string",
            "fareReferenceID" => "required|string",
            "fareReferenceName" => "required|string",
            "bookFlightSegmentSequence" => "required|string",
            "resBookDesigCode" => "required|string",
            "flightSegmentCode" => "required|string",
            "flightSegmentCodeContext" => "required|string",
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
            "arrivalDateTime" => "required|string",
            "arrivalDateTimeUTC" => "required|string",
            "departureAirportCitytLocationCode" => "required|string",
            "departureAirportCityLocationName" => "required|string",
            "departureAirportCityLocationNameLanguage" => "required|string",
            "departureAirportCountryLocationCode" => "required|string",
            "departureAirportCountryLocationName" => "required|string",
            "departureCountryLocationNameLanguage" => "required|string",
            "departureCountryCurrencyCode" => "required|string",
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
            "departureAirportSector" => "required|string",
            "departureFlightCodeShare" => "required|boolean",
            "departureFlightDistance" => "required|string",
            "equipmentAirEquipType" => "required|string",
            "equipmentChangeOfGauge" => "required|boolean",
            "flightNotesDeiCodeOne" => "required|string",
            "flightNotesExplanationOne" => "required|string",
            "flightNoteOne" => "required|string",
            "flightNotesDeiCodeTwo" => "required|string",
            "flightNotesExplanationTwo" => "required|string",
            "flightNotesNoteTwo" => "required|string",
            "flightNoteDeiCodeThree" => "required|string",
            "flightExplanationThree" => "required|string",
            "flightNotesNoteThree" => "required|string",
            "flownMileageQty" => "required|string",
            "iatciFlight" => "required|boolean",
            "journeyDuration" => "required|string",
            "onTimeRate" => "required|string",
            "remark" => "required|string",
            "secureFlightDataRequired" => "required|boolean",
            "segmentStatusByFirstLeg" => "required|string",
            "stopQuantity" => "required|string",
            "involuntaryPermissionGiven" => "required|boolean",
            "legStatus" => "required|string",
            "referenceID" => "required|string",
            "responseCode" => "required|string",
            "sequenceNumber" => "required|string",
            "status" => "required|string",
            "accompaniedByInfant" => "required|boolean",
            "airTravelerbirthDate" => "required|string",
            "contactPersonEmail" => "required|string",
            "airTravelerListEmailMarkedForSendingRezInfo" => "required|boolean",
            "emailPreferred" => "required|boolean",
            "emailSharedMarketInd" => "required|boolean",
            "airTravelerListPersonNameGivenName" => "required|string",
            "airTravelerListpersonNameShareMarketInd" => "required|boolean",
            "airTravelerListPersonNameSurname" => "required|string",
            "phoneNumberAreaCode" => "required|string",
            "phoneCountryCode" => "required|string",
            "phoneNumberEmailMarkedForSendingRezInfo" => "required|boolean",
            "phoneNumberPreferred" => "required|boolean",
            "phoneNumberShareMarketInd" => "required|boolean",
            "phoneNumberSubscriberNumber" => "required|string",
            "airTravelerShareContactInfo" => "required|boolean",
            "airTravelerShareMarketInd" => "required|boolean",
            "useForInvoicing" => "required|boolean",
            'documentInfoBirthDate' => "required|string",
            "documentHolderFormattedGivenName" => "required|string",
            "documentHolderFormattedShareMarketInd" => "required|boolean",
            "documentHolderFormattedSurname" => "required|string",
            "documentHolderFormattedGender" => "required|string",
            "emergencyContactInfoshareMarketInd" => "required|boolean",
            "decline" => "required|boolean",
            "emergencyContactMarkedForSendingRezInfo" => "required|boolean",
            "emergencyContactPreferred" => "required|boolean",
            "emergencyContactShareMarketInd" => "required|boolean",
            "shareContactInfo" => "required|boolean",
            "airTravelerGender" => "required|string",
            "airTravelerHasStrecher" => "required|boolean",
            "parentSequence" => "required|string",
            "passengerTypeCode" => "required|string",
            "personNameGivenName" => "required|string",
            "personNameTitle" => "required|string",
            "personNameshareMarketInd" => "required|boolean",
            "personNameSurname" => "required|string",
            "personNameENGivenName" => "required|string",
            "personNameENTitle" => "required|string",
            "personNameENShareMarketInd" => "required|boolean",
            "personNameENShareMarketSurname" => "required|string",
            "requestedSeatCount" => "required|string",
            "shareMarketInd" => "required|boolean",
            "travelerReferenceID" => "required|string",
            "airTravelUnaccompaniedMinor" => "required|boolean",
            "airTravelerSequence" => "required|string",
            "flightSegmentSequence" => "required|string",
            "airTravelerSsrCode" => "required|string",
            "airTravelerSsrGroup" => "required|string",
            "ssrExplanation" => "required|string",
            "cityCode" => "required|string",
            "companyCode" => "required|string",
            "bookingRequestListCodeContext" => "required|string",
            "companyFullName" => "required|string",
            "companyShortName" => "required|string",
            "bookingReferenceCountryCode" => "required|string",
            "bookingReferenceIDID" => "required|string",
            "bookingReferenceID" => "required|string"
        ];
    }
}
