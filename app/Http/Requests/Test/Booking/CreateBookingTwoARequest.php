<?php

namespace App\Http\Requests\Test\Booking;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingTwoARequest extends FormRequest
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
            'CreateBookOriginDestinationOptionList' => 'required|array',
            'CreateBookOriginDestinationOptionList.*.actionCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.bookingClassCabin' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.bookingClassResBookDesigCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.bookingClassResBookDesigQuantity' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.bookingClassResBookDesigStatusCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareInfoCabin' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareInfoCabinClassCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareBaggageAllowanceType' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareBaggageMaxAllowedPieces' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.unitOfMeasureCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.maxAllowedWeight' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareGroupName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareReferenceCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareReferenceID' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareReferenceName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.flightSegmeneSequence' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareInfoPortTax' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.fareInfoResBookDesigCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.airlineCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.airlineCompanyFullName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportCityLocationCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportCityLocationName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportCityLocationNameLanguage' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportCountryLocationCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportCountryLocationName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportCountryLocationNameLanguage' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportCountryCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportCodeContext' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportLanguage' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportLocationCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportLocationName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalAirportTimeZoneInfo' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalDateTime' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.arrivalDateTimeUTC' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportCityLocationCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportCityLocationName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportCityLocationNameLanguage' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportCountryLocationCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportCountryLocationName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportCountryLocationNameLanguage' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportCountryCurrencyCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportCodeContext' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportLanguage' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportLocationCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportLocationName' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureAirportTimeZoneInfo' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureDateTime' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.departureDateTimeUTC' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.flightNumber' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.flightSegmentID' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.ondControlled' => 'required|boolean',
            'CreateBookOriginDestinationOptionList.*.sector' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.codeshare' => 'required|boolean',
            'CreateBookOriginDestinationOptionList.*.distance' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.airEquipType' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.changeOfGuage' => 'required|boolean',
            
            'CreateBookOriginDestinationOptionList.*.flightNotes' => 'required|array',
            'CreateBookOriginDestinationOptionList.*.flightNotes.*.deiCode' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.flightNotes.*.explanation' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.flightNotes.*.note' => 'required|string',

            'CreateBookOriginDestinationOptionList.*.flownMileageQty' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.iatciFlight' => 'required|boolean',
            'CreateBookOriginDestinationOptionList.*.journeyDuration' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.onTimeRate' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.remark' => 'sometimes|string',
            'CreateBookOriginDestinationOptionList.*.secureFlightDataRequired' => 'required|boolean',
            'CreateBookOriginDestinationOptionList.*.stopQuantity' => 'required|string',
            'CreateBookOriginDestinationOptionList.*.ticketType' => 'required|string',
            'airTravelerList' => 'required|array',
            'airTravelerList.*.airTravelerListGender' => 'required|string',
            'airTravelerList.*.airTravelerPassengerTypeCode' => 'required|string',
            'airTravelerList.*.airTravelerListGivenName' => 'required|string',
            'airTravelerList.*.airTravelerListSurname' => 'required|string',
            'airTravelerList.*.airTravelerBirthDate' => 'required|string',
            'airTravelerList.*.contactPersonEmail' => 'required|string',
            'airTravelerList.*.contactPersonShareMarketInd' => 'required|boolean',
            'airTravelerList.*.contactPersonMarkedForSendingRezInfo' => 'required|boolean',
            'airTravelerList.*.contactPersonNameGivenName' => 'required|string',
            'airTravelerList.*.contactPersonSurname' => 'required|string',
            'airTravelerList.*.phoneNumberAreaCode' => 'required|string',
            'airTravelerList.*.phoneNumberCountryCode' => 'required|string',
            'airTravelerList.*.phoneNumberMarkedForSendingRezInfo' => 'required|boolean',
            'airTravelerList.*.phoneNumberSubscriberNumber' => 'required|string',
            'airTravelerList.*.shareMarketInd' => 'required|boolean',
            'airTravelerList.*.contactPersonSocialSecurityNumber' => 'required|string',
            'airTravelerList.*.shareContactInfo' => 'required|boolean',
            'airTravelerList.*.requestedSeatCount' => 'required|string',

            'airTravelerChildList' => 'sometimes|array',
            "airTravelerChildList.*.airTravelerListGenderChild" => "required|string",
            "airTravelerChildList.*.airTravelerListBirthDateChild" => "required|string",
            "airTravelerChildList.*.passengerTypeCodeChild" => "required|string",
            "airTravelerChildList.*.personNameGivenNameChild" => "required|string",
            "airTravelerChildList.*.personNameSurnameChild" => "required|string",
            "airTravelerChildList.*.contactPersonShareContactInfoChild" => "required|boolean",
            "airTravelerChildList.*.requestedSeatCountChild" => "required|string",

            "requestPurpose" => "required|string",

            'specialServiceRequestList' => 'sometimes|array',            
            "specialServiceRequestList.*.airTravelerSequence" => "required|string",
            "specialServiceRequestList.*.flightSegmentSequence" => "required|string",
            "specialServiceRequestList.*.SSRCode" => "required|string",
            "ancillaryRequestList.*.SSRGroup" => "sometimes|string",
            "specialServiceRequestList.*.SSRExplanation" => "required|string",            
            "specialServiceRequestList.*.ticketedServiceQuantity" => "required|string",
            "specialServiceRequestList.*.ticketedStatus" => "required|string",  
            
        ];
    }
}
