<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class AddWeightRequestTest extends FormRequest
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
            "flightNotes" => "required|array",
            "flightNotes.*.deiCode" => "required|string",
            "flightNotes.*.explanation" => "required|string",
            "flightNotes.*.note" => "required|string",            
            "flownMileageQty" => "required|string",
            "iatciFlight" => "required|boolean",
            "journeyDuration" => "required|string",
            "onTimeRate" => "required|string",
            "remark" => "sometimes|string",
            "secureFlightDataRequired" => "required|boolean",
            "segmentStatusByFirstLeg" => "required|string",
            "stopQuantity" => "required|string",
            "involuntaryPermissionGiven" => "required|boolean",
            "legStatus" => "required|string",
            "referenceID" => "required|string",
            "responseCode" => "required|string",
            "sequenceNumber" => "required|string",
            "status" => "required|string",
            "airTravelerList" => "required|array",
            "airTravelerList.*.accompaniedByInfant" => "required|boolean",
            "airTravelerList.*.airTravelerbirthDate" => "required|string",
            "airTravelerList.*.contactPersonEmail" => "required|string",
            "airTravelerList.*.airTravelerListEmailMarkedForSendingRezInfo" => "required|boolean",
            "airTravelerList.*.emailPreferred" => "required|boolean",
            "airTravelerList.*.emailSharedMarketInd" => "required|boolean",
            "airTravelerList.*.airTravelerListPersonNameGivenName" => "required|string",
            "airTravelerList.*.airTravelerListpersonNameShareMarketInd" => "required|boolean",
            "airTravelerList.*.airTravelerListPersonNameSurname" => "required|string",
            "airTravelerList.*.phoneNumberAreaCode" => "required|string",
            "airTravelerList.*.phoneCountryCode" => "required|string",
            "airTravelerList.*.phoneNumberEmailMarkedForSendingRezInfo" => "required|boolean",
            "airTravelerList.*.phoneNumberPreferred" => "required|boolean",
            "airTravelerList.*.phoneNumberShareMarketInd" => "required|boolean",
            "airTravelerList.*.phoneNumberSubscriberNumber" => "required|string",
            "airTravelerList.*.airTravelerShareContactInfo" => "required|boolean",
            "airTravelerList.*.airTravelerShareMarketInd" => "required|boolean",
            "airTravelerList.*.useForInvoicing" => "required|boolean",
            'airTravelerList.*.documentInfoBirthDate' => "required|string",
            "airTravelerList.*.documentHolderFormattedGivenName" => "required|string",
            "airTravelerList.*.documentHolderFormattedShareMarketInd" => "required|boolean",
            "airTravelerList.*.documentHolderFormattedSurname" => "required|string",
            "airTravelerList.*.documentHolderFormattedGender" => "required|string",
            "airTravelerList.*.emergencyContactInfoshareMarketInd" => "required|boolean",
            "airTravelerList.*.decline" => "required|boolean",
            "airTravelerList.*.emergencyContactMarkedForSendingRezInfo" => "required|boolean",
            "airTravelerList.*.emergencyContactPreferred" => "required|boolean",
            "airTravelerList.*.emergencyContactShareMarketInd" => "required|boolean",
            "airTravelerList.*.shareContactInfo" => "required|boolean",
            "airTravelerList.*.airTravelerGender" => "required|string",
            "airTravelerList.*.airTravelerHasStrecher" => "required|boolean",
            "airTravelerList.*.parentSequence" => "required|string",
            "airTravelerList.*.passengerTypeCode" => "required|string",
            "airTravelerList.*.personNameGivenName" => "required|string",
            "airTravelerList.*.personNameTitle" => "required|string",
            "airTravelerList.*.personNameshareMarketInd" => "required|boolean",
            "airTravelerList.*.personNameSurname" => "required|string",
            "airTravelerList.*.personNameENGivenName" => "required|string",
            "airTravelerList.*.personNameENTitle" => "required|string",
            "airTravelerList.*.personNameENShareMarketInd" => "required|boolean",
            "airTravelerList.*.personNameENShareMarketSurname" => "required|string",
            "airTravelerList.*.requestedSeatCount" => "required|string",
            "airTravelerList.*.shareMarketInd" => "required|boolean",
            "airTravelerList.*.travelerReferenceID" => "required|string",
            "airTravelerList.*.airTravelUnaccompaniedMinor" => "required|boolean",

            "ancillaryRequestList" => "required|array",
            "ancillaryRequestList.*.airTravelerSequence" => "required|string",
            "ancillaryRequestList.*.flightSegmentSequence" => "required|string",
            "ancillaryRequestList.*.airTravelerSsrCode" => "required|string",
            "ancillaryRequestList.*.airTravelerSsrGroup" => "required|string",
            "ancillaryRequestList.*.ssrExplanation" => "required|string",
            "bookingReferenceIDID" => "required|string",
            "bookingReferenceID" => "required|string"
        ];
    }
}
