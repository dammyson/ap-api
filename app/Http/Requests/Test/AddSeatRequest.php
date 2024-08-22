<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

class AddSeatRequest extends FormRequest
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
            "actionCode" => "required|string", 
            "addOnSegment" => "required|boolean", 
            "cabin" => "required|string", 
            "resBookDesigCode" => "required|string", 
            "resBookDesigQuantity" => "required|string",
            "fareInfoCabin" => "required|string", 
            "cabinClassCode" => "required|string", 
            "allowanceType" => "required|string", 
            "maxAllowedPieces" => "required|string", 
            "unitOfMeasureCode" => "required|string", 
            "weight" => "required|string", 
            "fareGroupName" => "required|string", 
            "fareReferenceCode" => "required|string", 
            "fareReferenceID" => "required|string", 
            "fareReferenceName" => "required|string", 
            "flightSegmentSequence" => "required|string",
            "flightSegmentResBookDesigCode" => "required|string", 
            "airlineCode" => "required|string", 
            "airlineCodeContext" => "required|string",
            "arrivalAirportCityLocationCode" => "required|string", 
            "arrivalAirportCityLocationName" => "required|string", 
            "arrivalAirportCityLocationNameLanguage" => "required|string", 
            "arrivalAirportCountryLocationCode" => "required|string",
            "arrivalAirportCountryLocationName" => "required|string", 
            "arrivalAirportCountryLocationNameLanguage" => "required|string", 
            "arrivalAirportCurrencyCode" => "required|string", 
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
            "departureAirportCountryLocationNameLanguage" => "required|string", 
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
            "bookFlightSegmentSector" => "required|string", 
            "bookFlightSegmentCodeShare" => "required|boolean", 
            "bookFlightSegmentDistance" => "required|string", 
            "airEquipType" => "required|string", 
            "changeOfGauge" => "required|boolean", 
            "DeiCodeOne" => "required|string", 
            "explanationOne" => "required|string", 
            "noteOne" => "required|string", 
            "DeiCodeTwo" => "required|string",
            "explanationTwo" => "required|string", 
            "noteTwo" => "required|string", 
            "DeiCodeThree" => "required|string", 
            "explanationThree" => "required|string", 
            "noteThree" => "required|string", 
            "flownMileageQty" => "required|string", 
            "iatciFlight" => "required|boolean", 
            "journeyDuration" => "required|string", 
            "onTimeRate" => "required|string", 
            "remark" => "required|string", 
            "secureFlightDataRequired" => "required|boolean", 
            "segmentStatusByFirstLeg" => "required|string", 
            "stopQuantity" => "required|string", 
            "involuntaryPermissionGiven" => "required|boolean", 
            "bookingLegStatus" => "required|string", 
            "bookingReferenceID" => "required|string", 
            "bookingResponseCode" => "required|string", 
            "bookingSequenceNumber" => "required|string", 
            "bookingFlightStatus" => "required|string", 
            "accompaniedByInfant" => "required|boolean", 
            "airTravelerListbirthDate" => "required|string", 
            "contactPersonEmail" => "required|string", 
            "emailMarkedForSendingRezInfo" => "required|boolean", 
            "emailPreferred" => "required|boolean", 
            "emailSharedMarketInd" => "required|boolean", 
            "contactPersonGivenName" => "required|string", 
            "contactPersonShareMarketIndOne" => "required|boolean", 
            "personNameSurname" => "required|string", 
            "phoneNumberAreaCode" => "required|string", 
            "phoneNumberCountryCode" => "required|string", 
            "phoneNumberMarkedForSendingRezInfo" => "required|boolean", 
            "phoneNumberPreferred" => "required|boolean", 
            "phoneNumberShareMarketInd" => "required|boolean", 
            "phoneNumberSubscriberNumber" => "required|string", 
            "contactPersonShareContactInfo" => "required|boolean",
            "contactPersonShareMarketIndTwo" => "required|boolean", 
            "contactPersonUseForInvoicing" => "required|boolean", 
            "documentInfoListBirthDate" => "required|string", 
            "documentInfoListGivenName" => "required|string", 
            "documentInfoListShareMarketInd" => "required|boolean", 
            "documentInfoSurname" => "required|string", 
            "documentInfoListGender" => "required|string", 
            "emergencyContactInfoShareMarketInd" => "required|boolean", 
            "emergencyContactInfoDecline" => "required|boolean", 
            "emergencyContactMarkedForSendingRezInfo" => "required|boolean", 
            "emergencyContactPreferred" => "required|boolean", 
            "emergencyContactShareMarketInd" => "required|boolean", 
            "emergencyContactShareContactInfo" => "required|boolean", 
            "contactPersonGender" => "required|string", 
            "contactPersonHasStrecher" => "required|boolean", 
            "contactPersonParentSequence" => "required|string", 
            "contactPersonPassengerTypeCode" => "required|string", 
            "personNameGivenName" => "required|string", 
            "personNameNameTitle" => "required|string", 
            "personNameShareMarketInd" => "required|boolean", 
            "personNameENGivenName" => "required|string", 
            "personNameENNameTitle" => "required|string", 
            "personNameENShareMarketInd" => "required|boolean", 
            "personNameENSurname" => "required|string", 
            "requestedSeatCount" => "required|string", 
            "airTravelerListShareMarketInd" => "required|boolean", 
            "travelerReferenceID" => "required|string", 
            "unaccompaniedMinor" => "required|boolean",
            "airTravelerSequence" => "required|string", 
            "ancillaryRequestListFlightSegmentSequence" => "required|string", 
            "ssrCode" => "required|string",
            "ssrGroup" => "required|string",
            "ssrExplanation" => "required|string", 
            "bookingReferenceCompanyCityCode" => "required|string", 
            "bookingReferenceCompanyCode" => "required|string", 
            "bookingReferenceCodeContext" => "required|string", 
            "bookingReferenceCompanyFullName" => "required|string", 
            "bookingReferenceCompanyShortName" => "required|string", 
            "bookingReferenceCountryCode" => "required|string", 
            "bookingReferenceIDID" => "required|string", 
            "referenceID" => "required|string"
        ];
    }
}
