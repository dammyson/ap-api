<?php

namespace App\Http\Requests\Test\Booking;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRTRequest extends FormRequest
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
            "bookingFlightActionCode" => "required|string",
            "bookingFlightCabin" => "required|string",
            "bookingFlightResBookDesigCode" => "required|string",
            "bookingFlightResBookDesigQuantity" => "required|string",
            'bookingFlightResBookDesigStatusCode' => "required|string",
            "fareInfoCabin" => "required|string",
            "fareInfoCabinClassCode" => "required|string",
            "bookingFlightFareBaggageAllowanceType" => "required|string",
            "bookingFlightFareBaggageMaxAllowedPieces" => "required|string",
            "unitOfMeasureCode" => "required|string",
            "fareInfoMaxAllowedWeight" => "required|string",
            "fareInfoFareGroupName" => "required|string",
            "fareInfoFareReferenceCode" => "required|string",
            "fareInfoFareReferenceID" => "required|string",
            "fareInfoFareReferenceName" => "required|string",
            "fareInfoFlightSegmentSequence" => "required|string",
            "fareInfoPortTax" => "required|string",
            "resBookDesigCode" => "required|string",
            "flightSegmentCode" => "required|string",
            "flightSegmentCompanyFullName" => "required|string",
            "arrivalAirporCityLocationCodeOne" => "required|string",
            "arrivalAirportCityLocationNameOne" => "required|string",
            "arrivalAirportCityLocationNameLanguageOne" => "required|string", 
            "arrivalAirportCountryLocationCodeOne" => "required|string",
            "arrivalAirportCountryLocationNameOne" => "required|string",
            "arrivalAirportCountryLocationNameLanguageOne" => "required|string",
            "arrivalAirportCurrencyCodeOne" => "required|string",
            "arrivalAirportCodeContextOne" => "required|string",
            "arrivalAirportLanguageOne" => "required|string",
            "arrivalAirportLocationCodeOne" => "required|string",
            "arrivalAirportLocationNameOne" => "required|string",
            "arrivalAirportTimeZoneInfoOne" => "required|string",
            "arrivalDateTimeOne" => "required|string",
            "arrivalDateTimeUTCOne" => "required|string",
            "departureAirportCityLocationCodeOne" => "required|string",
            "departureAirportCityLocationNameOne" => "required|string",
            "departureAirportCityLocationNameLanguageOne" => "required|string",
            "departureAirportCountryLocationCodeOne" => "required|string",
            "departureAirportCountryLocationNameOne" => "required|string",
            "departureAirportCountryLocationNameLanguageOne" => "required|string",
            "departureAirportCountryCurrencyCodeOne" => "required|string",
            "departureAirportCodeContextOne" => "required|string",
            "departureAirportLanguageOne" => "required|string",
            "departureAirportLocationCodeOne" => "required|string",
            "departureAirportLocationNameOne" => "required|string",
            "departureAirportTimeZoneInfoOne" => "required|string",
            "departureDateTimeOne" => "required|string",
            "departureDateTimeUTCOne" => "required|string",
            "flightNumberOne" => "required|string",
            "flightSegmentIDOne" => "required|string",
            "ondControlledOne" => "required|boolean",
            "sectorOne" => "required|string",
            "codeShareOne" => "required|boolean",
            "distanceOne" => "required|string",
            "equipmentAirEquipType" => "required|string",
            "equipmentChangeOfGauge" => "required|boolean",
            "flightNotesDeiCodeOne" => "required|string",
            "flightNotesExplanationOne" => "required|string",
            "flightNotesNoteOne" => "required|string",
            "flightNotesDeiCodeTwo" => "required|string",
            "flightNotesExplanationTwo" => "required|string",
            "flightNotesNoteTwo" => "required|string",
            "flightNoteDeiCodeThree" => "required|string",
            "flightNotesExplanationThree" => "required|string",
            "flightNotesNoteThree" => "required|string",
            "flownMileageQty" => "required|string",
            "iatciFlight" => "required|boolean",
            "journeyDurationOne" => "required|string",
            "onTimeRateOne" => "required|string",
            "flightSegmentRemark" => "required|string",
            "secureFlightDataRequired" => "required|boolean",
            "stopQuantityOne" => "required|string",
            "ticketTypeOne" => "required|string",
            "bookingFlightSegmentActionCodeTwo" => "required|string",
            "bookingClassCabinTwo" => "required|string",
            "bookingClassResBookDesigCodeTwo" => "required|string",
            "bookingClassResBookDesigQuantityTwo" => "required|string",
            "bookingClassResBookDesigStatusCodeTwo" => "required|string",
            "fareInfoCabinTwo" => "required|string",
            "fareInfoCabinClassCodeTwo" => "required|string",
            "fareBaggageAllowanceTypeTwo" => "required|string",
            "fareBaggageMaxAllowedPiecesTwo" => "required|string",
            "maxAllowedWeightUnitOfMeasureCodeTwo" => "required|string",
            "maxAllowedWeightTwo" => "required|string",
            "fareGroupNameTwo" => "required|string",
            "fareReferenceCodeTwo" => "required|string",
            "fareReferenceIDTwo" => "required|string",
            "fareReferenceNameTwo" => "required|string",
            "flightSegmentSequenceTwo" => "required|string",
            "portTaxTwo" => "required|string",
            "fareInfoResBookDesigCodeTwo" => "required|string",
            "airlineCodeTwo" => "required|string",
            "airlineCompanyFullNameTwo" => "required|string",
            "arrivalAirportCityLocationCodeTwo" => "required|string",
            "arrivalAirportCityLocationNameTwo" => "required|string",
            "arrivalAirportCityLocationNameLanguageTwo" => "required|string", 
            "arrivalAirportCountryLocationCodeTwo" => "required|string",
            "arrivalAirportCountryLocationNameTwo" => "required|string",
            "arrivalAirportCountryLocationNameLanguageTwo" => "required|string",
            "arrivalAirportCurrencyCodeTwo" => "required|string",
            "arrivalAirportCodeContextTwo" => "required|string",
            "arrivalAirportLanguageTwo" => "required|string",
            "arrivalAirportLocationCodeTwo" => "required|string",
            "arrivalAirportLocationNameTwo" => "required|string",
            "arrivalAirportTimeZoneInfoTwo" => "required|string",
            "arrivalDateTimeTwo" => "required|string",
            "arrivalDateTimeUTCTwo" => "required|string",
            "departureAirportCityLocationCodeTwo" => "required|string",
            "departureAirportCityInfoLocationNameTwo" => "required|string",
            "departureAirportCityLocationNameLanguageTwo" => "required|string",
            "departureAirportCountryLocationCodeTwo" => "required|string",
            "departureAirportCountryLocationNameTwo" => "required|string",
            "departureAirportCountryLocationNameLanguageTwo" => "required|string",
            "deparutureAirportCountryCurrencyCodeTwo" => "required|string",
            "departureAirportCodeContextTwo" => "required|string",
            "departureAirportLanguageTwo" => "required|string",
            "departureAirportLocationCodeTwo" => "required|string",
            "departureAirportLocationNameTwo" => "required|string",
            "departureAirportTimeZoneInfoTwo" => "required|string",
            "departureDateTimeTwo" => "required|string",
            "departureDateTimeUTCTwo" => "required|string",
            "flightNumberTwo" => "required|string",
            "flightSegmentIDTwo" => "required|string",
            "ondControlledTwo" => "required|boolean",
            "sectorTwo" => "required|string",
            "codeshareTwo" => "required|boolean",
            "distanceTwo" => "required|string",
            "airEquipTypeTwo" => "required|string",
            "changeOfGuageTwo" => "required|boolean",
            "flightNotesDeiCodeFour" => "required|string",
            "flightNotesExplanationFour" => "required|string",
            "flightNotesNoteFour" => "required|string",
            "flightNotesDeiCodeFive" => "required|string",
            "flightNotesExplanationFive" => "required|string",
            "flightNotesNoteFive" => "required|string",
            "flownMileageQtyTwo" => "required|string",
            "iatciFlightTwo" => "required|boolean",
            "journeyDurationTwo" => "required|string",
            "onTimeRateTwo" => "required|string",
            "secureFlightDataRequiredTwo" => "required|boolean",
            "stopQuantityTwo" => "required|string",
            "ticketTypeTwo" => "required|string",
            "airTravelerListGenderTwo" => "required|string",
            "airTravelerListPassengerTypeCodeTwo" => "required|string",
            "airTravelerListPersonNameGivenNameTwo" => "required|string",
            "airTravelerListSurnameTwo" => "required|string",
            "airTravelerListBirthDateTwo" => "required|string",
            "contactPersonEmail" => "required|string",
            "contactPersonShareMarketInd" => "required|boolean",
            "contactPersonMarkedForSendingRezInfo" => "required|boolean",
            "contactPersonPersonNameGivenName" => "required|string",
            "contactPersonPersonNameSurname" => "required|string",
            "phoneNumberAreaCode" => "required|string",
            "phoneNumberCountryCode" => "required|string",
            "phoneNumberMarkedForSendingRezInfo" => "required|boolean",
            "phoneNumberSubscriberNumber" => "required|string",
            "phoneNumberShareMarketInd" => "required|boolean",
            "phoneNumberSocialSecurityNumber" => "required|string",
            "shareContactInfo" => "required|boolean",
            "requestedSeatCount" => "required|string",
            "requestPurpose" => "required|string",
            "capturePayment" => "required|boolean",
            "paymentCode" => "required|string",
            "threeDomainSecurityEligible" => "required|boolean",
            "MCONumber" => "required|string",
            "paymentAmountCurrencyCode" => "required|string",
            "paymentType" => "required|string",
            "primaryPayment" => "required|boolean"
        ];
    }
}
