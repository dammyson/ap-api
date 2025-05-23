<?php

namespace App\Http\Requests\SSR;

use Illuminate\Foundation\Http\FormRequest;

class AddSsrRequest extends FormRequest
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
            "airItinerary" => "required|array",
            "airItinerary.*.bookFlightSegmentListActionCode" => "required|string",
            "airItinerary.*.bookFlightAddOnSegment" => "required|boolean",
            "airItinerary.*.bookingClassCabin" => "required|string",
            "airItinerary.*.bookingClassResBookDesigCode" => "required|string",
            "airItinerary.*.resBookDesignQuantity" => "required|string",
            "airItinerary.*.fareInfoCabin" => "required|string",
            "airItinerary.*.fareInfoCabinClassCode" => "required|string",
            "airItinerary.*.fareBaggageAllowanceType" => "required|string",
            "airItinerary.*.fareBaggageMaxAllowedPieces" => "required|string",
            "airItinerary.*.unitOfMeasureCode" => "required|string",
            "airItinerary.*.fareBaggageAllowanceWeight" => "required|string",
            "airItinerary.*.fareGroupName" => "required|string",
            "airItinerary.*.fareReferenceCode" => "required|string",
            "airItinerary.*.fareReferenceID" => "required|string",
            "airItinerary.*.fareReferenceName" => "required|string",
            "airItinerary.*.bookFlightSegmentSequence" => "required|string",
            "airItinerary.*.resBookDesigCode" => "required|string",
            "airItinerary.*.flightSegmentCode" => "required|string",
            "airItinerary.*.flightSegmentCodeContext" => "required|string",
            "airItinerary.*.arrivalAirportCityLocationCode" => "required|string",
            "airItinerary.*.arrivalAirportCityLocationName" => "required|string",
            "airItinerary.*.arrivalAirportCityLocationNameLanguage" => "required|string",
            "airItinerary.*.arrivalAirportCountryLocationCode" => "required|string",
            "airItinerary.*.arrivalAirportCountryLocationName" => "required|string",
            "airItinerary.*.arrivalAirportCountryLocationNameLanguage" => "required|string",
            "airItinerary.*.arrivalAirportCountryCurrencyCode" => "required|string",
            "airItinerary.*.arrivalAirportCodeContext" => "required|string",
            "airItinerary.*.arrivalAirportLanguage" => "required|string",
            "airItinerary.*.arrivalAirportLocationCode" => "required|string",
            "airItinerary.*.arrivalAirportLocationName" => "required|string",
            "airItinerary.*.arrivalAirportTerminal" => "sometimes|string",
            "airItinerary.*.arrivalAirportTimeZoneInfo" => "required|string",
            "airItinerary.*.arrivalDateTime" => "required|string",
            "airItinerary.*.arrivalDateTimeUTC" => "required|string",
            "airItinerary.*.departureAirportCitytLocationCode" => "required|string",
            "airItinerary.*.departureAirportCityLocationName" => "required|string",
            "airItinerary.*.departureAirportCityLocationNameLanguage" => "required|string",
            "airItinerary.*.departureAirportCountryLocationCode" => "required|string",
            "airItinerary.*.departureAirportCountryLocationName" => "required|string",
            "airItinerary.*.departureCountryLocationNameLanguage" => "required|string",
            "airItinerary.*.departureCountryCurrencyCode" => "required|string",
            "airItinerary.*.departureAirportCodeContext" => "required|string",
            "airItinerary.*.departureAirportLanguage" => "required|string",
            "airItinerary.*.departureAirportLocationCode" => "required|string",
            "airItinerary.*.departureAirportLocationName" => "required|string",
            "airItinerary.*.departureAirportTimeZoneInfo" => "required|string",
            "airItinerary.*.departureDateTime" => "required|string",
            "airItinerary.*.departureDateTimeUTC" => "required|string",
            "airItinerary.*.flightNumber" => "required|string",
            "airItinerary.*.flightSegmentID" => "required|string",
            "airItinerary.*.ondControlled" => "required|boolean",
            "airItinerary.*.departureAirportSector" => "required|string",
            "airItinerary.*.departureFlightCodeShare" => "required|boolean",
            "airItinerary.*.departureFlightDistance" => "required|string",
            "airItinerary.*.equipmentAirEquipType" => "required|string",
            "airItinerary.*.equipmentChangeOfGauge" => "required|boolean",
            "airItinerary.*.flightNotes" => "required|array",
            "airItinerary.*.flightNotes.*.deiCode" => "required|string",
            "airItinerary.*.flightNotes.*.explanation" => "required|string",
            "airItinerary.*.flightNotes.*.note" => "required|string",            
            "airItinerary.*.flownMileageQty" => "required|string",
            "airItinerary.*.iatciFlight" => "required|boolean",
            "airItinerary.*.journeyDuration" => "required|string",
            "airItinerary.*.onTimeRate" => "required|string",
            "airItinerary.*.remark" => "sometimes|string",
            "airItinerary.*.secureFlightDataRequired" => "required|boolean",
            "airItinerary.*.segmentStatusByFirstLeg" => "required|string",
            "airItinerary.*.stopQuantity" => "required|string",
            "airItinerary.*.involuntaryPermissionGiven" => "required|boolean",
            "airItinerary.*.legStatus" => "required|string",
            "airItinerary.*.referenceID" => "required|string",
            "airItinerary.*.responseCode" => "required|string",
            "airItinerary.*.sequenceNumber" => "required|string",
            "airItinerary.*.status" => "required|string",
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
