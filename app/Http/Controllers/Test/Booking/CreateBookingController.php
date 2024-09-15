<?php

namespace App\Http\Controllers\Test\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Booking\createBookingOWRequest;
use App\Http\Requests\Test\Booking\CreateBookingRTRequest;
use App\Http\Requests\Test\Booking\CreateBookingTwoARequest;
use App\Services\Soap\CreateBookingBuilder;
use Illuminate\Http\Request;

class CreateBookingController extends Controller
{
    protected $createBookingBuilder;
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;

    public function __construct(CreateBookingBuilder $createBookingBuilder) {
        $this->createBookingBuilder = $createBookingBuilder;

        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }

    public function createBookingRT(CreateBookingRTRequest $request) {
        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];        
        $requestPurpose = $request->input('requestPurpose');
        $capturePayment = $request->input('capturePayment');
        $paymentCode = $request->input('paymentCode');
        $threeDomainSecurityEligible = $request->input('threeDomainSecurityEligible');
        $MCONumber = $request->input('MCONumber');
        $paymentAmountCurrencyCode = $request->input('paymentAmountCurrencyCode');
        $paymentType = $request->input('paymentType');
        $primaryPayment = $request->input('primaryPayment');

        $xml = $this->createBookingBuilder->createBookingRT(            
            $CreateBookOriginDestinationOptionList,
            $airTravelerList,
            $requestPurpose,
            $capturePayment,
            $paymentCode,
            $threeDomainSecurityEligible,
            $MCONumber,
            $paymentAmountCurrencyCode,
            $paymentType,
            $primaryPayment
        );
        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

            dd( $response );

            $result = "";
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function createBookingOW(createBookingOWRequest $request) {

        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];
        $requestPurpose = $validated["requestPurpose"];

        $xml = $this->createBookingBuilder->createBookingOW(
            $CreateBookOriginDestinationOptionList, 
            $airTravelerList,
            $requestPurpose
        );
       
        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

            dd( $response );

            $result = "";
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function createBookingTwoA(CreateBookingTwoARequest $request){
        $actionCode = $request->input('actionCode');
        $cabin = $request->input('cabin');
        $airItineraryResBookDesigCode = $request->input('airItineraryResBookDesigCode');
        $airItineraryResBookDesigQuantity = $request->input('airItineraryResBookDesigQuantity');
        $airItineraryResBookDesigStatusCode = $request->input('airItineraryResBookDesigStatusCode');
        $fareInfoCabin = $request->input('fareInfoCabin');
        $fareInfoClassCode = $request->input('fareInfoClassCode');
        $fareBaggageAllowanceType = $request->input('fareBaggageAllowanceType');
        $fareBaggageAllowanceMaxAllowedPieces = $request->input('fareBaggageAllowanceMaxAllowedPieces');
        $unitOfMeasureCode = $request->input('unitOfMeasureCode');
        $weight = $request->input('weight');
        $fareGroupName = $request->input('fareGroupName');
        $fareReferenceCode = $request->input('fareReferenceCode');
        $fareReferenceID = $request->input('fareReferenceID');
        $fareReferenceName = $request->input('fareReferenceName');
        $fareInfoFlightSegmentSequence = $request->input('fareInfoFlightSegmentSequence');
        $fareInfoPortTax = $request->input('fareInfoPortTax');
        $fareInfoResBookDesigCode = $request->input('fareInfoResBookDesigCode');
        $airlineCode = $request->input('airlineCode');
        $airlineCompanyFullName = $request->input('airlineCompanyFullName');
        $arrivalAirportCityLocationCode = $request->input('arrivalAirportCityLocationCode');
        $arrivalAirportCityLocationName = $request->input('arrivalAirportCityLocationName');
        $arrivalAirportCityLocationNameLanguage = $request->input('arrivalAirportCityLocationNameLanguage');
        $arrivalAirportCountryLocationCode = $request->input('arrivalAirportCountryLocationCode');
        $arrivalAirportCountryLocationName = $request->input('arrivalAirportCountryLocationName');
        $arrivalAirportCountryLocationNameLanguage = $request->input('arrivalAirportCountryLocationNameLanguage');
        $arrivalAirportCountryCurrencyCode = $request->input('arrivalAirportCountryCurrencyCode');
        $arrivalAirportCodeContext = $request->input('arrivalAirportCodeContext');
        $arrivalAirportLanguage = $request->input('arrivalAirportLanguage');
        $arrivalAirportLocationCode = $request->input('arrivalAirportLocationCode');
        $arrivalAirportLocationName = $request->input('arrivalAirportLocationName');
        $arrivalAirportTimeZoneInfo = $request->input('arrivalAirportTimeZoneInfo');
        $arrivalAirportDateTime = $request->input('arrivalAirportDateTime');
        $arrivalAirportDateTimeUTC = $request->input('arrivalAirportDateTimeUTC');
        $departureAirportCityLocationCode = $request->input('departureAirportCityLocationCode');
        $departureAirportCityLocationName = $request->input('departureAirportCityLocationName');
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountryLocationCode = $request->input('departureAirportCountryLocationCode');
        $departureAirportCountryLocationName = $request->input('departureAirportCountryLocationName');
        $departureAirportLocationNameLanguage = $request->input('departureAirportLocationNameLanguage');
        $departureAirportCountryCurrencyCode = $request->input('departureAirportCountryCurrencyCode');
        $departureAirportCodeContext = $request->input('departureAirportCodeContext');
        $departureAirportLanguage = $request->input('departureAirportLanguage');
        $departureAirportLocationCode = $request->input('departureAirportLocationCode');
        $departureAirportLocationName = $request->input('departureAirportLocationName');
        $departureAirportTimeZoneInfo = $request->input('departureAirportTimeZoneInfo');
        $departureDateTime = $request->input('departureDateTime');
        $departureDateTimeUTC = $request->input('departureDateTimeUTC');
        $flightNumber = $request->input('flightNumber');
        $flightSegmentID = $request->input('flightSegmentID');
        $ondControlled = $request->input('ondControlled');
        $sector = $request->input('sector');
        $codeShare = $request->input('codeShare');
        $distance = $request->input('distance');
        $equipmentAirEquipType = $request->input('equipmentAirEquipType');
        $equipmentChangeOfGauge = $request->input('equipmentChangeOfGauge');
        $flightNotesDeiCodeOne = $request->input('flightNotesDeiCodeOne');
        $flightNotesExplanationOne = $request->input('flightNotesExplanationOne');
        $flightNotesNoteOne = $request->input('flightNotesNoteOne');
        $flightNotesDeiCodeTwo = $request->input('flightNotesDeiCodeTwo');
        $flightNotesExplanationTwo = $request->input('flightNotesExplanationTwo');
        $flightNotesNoteTwo = $request->input('flightNotesNoteTwo');
        $flightNotesDeiCodeThree = $request->input('flightNotesDeiCodeThree');
        $flightNotesExplanationThree = $request->input('flightNotesExplanationThree');
        $flightNotesNoteThree = $request->input('flightNotesNoteThree');
        $flownMileageQty = $request->input('flownMileageQty');
        $iatciFlight = $request->input('iatciFlight');
        $journeyDuration = $request->input('journeyDuration');
        $onTimeRate = $request->input('onTimeRate');
        $remark = $request->input('remark');
        $secureFlightDataRequired = $request->input('secureFlightDataRequired');
        $stopQuantity = $request->input('stopQuantity');
        $ticketType = $request->input('ticketType');
        $airTravelerListGenderOne = $request->input('airTravelerListGenderOne');
        $airTravelerPassengerTypeCodeOne = $request->input('airTravelerPassengerTypeCodeOne');
        $airTravelerPersonGivenNameOne = $request->input('airTravelerPersonGivenNameOne');
        $airTravelerSurnameOne = $request->input('airTravelerSurnameOne');
        $airTravelerBirthDateOne = $request->input('airTravelerBirthDateOne');
        $contactPersonEmailOne = $request->input('contactPersonEmailOne');
        $emailShareMarketIndOne = $request->input('emailShareMarketIndOne');
        $contactPersonMarkedForSendingRezInfoOne = $request->input('contactPersonMarkedForSendingRezInfoOne');
        $personNameGivenNameOne = $request->input('personNameGivenNameOne');
        $personNameSurnameOne = $request->input('personNameSurnameOne');
        $contactPersonBirthDateOne = $request->input('contactPersonBirthDateOne');
        $phoneNumberAreaCodeOne = $request->input('phoneNumberAreaCodeOne');
        $phoneNumberCountryCodeOne = $request->input('phoneNumberCountryCodeOne');
        $phoneNumberMarkedForSendingRezInfoOne = $request->input('phoneNumberMarkedForSendingRezInfoOne');
        $phoneNumberSubscriberNumberOne = $request->input('phoneNumberSubscriberNumberOne');
        $contactPersonShareMarketIndOne = $request->input('contactPersonShareMarketIndOne');
        $contactPersonSocialSecurityNumberOne = $request->input('contactPersonSocialSecurityNumberOne');
        $contactPersonShareContactInfoOne = $request->input('contactPersonShareContactInfoOne');
        $contactPersonRequestedSeatCountOne = $request->input('contactPersonRequestedSeatCountOne');
        $airTravelerListGenderTwo = $request->input('airTravelerListGenderTwo');
        $airTravelerPassengerTypeCodeTwo = $request->input('airTravelerPassengerTypeCodeTwo');
        $airTravelerPersonGivenNameTwo = $request->input('airTravelerPersonGivenNameTwo');
        $airTravelerSurnameTwo = $request->input('airTravelerSurnameTwo');
        $airTravelerBirthDateTwo = $request->input('airTravelerBirthDateTwo');
        $contactPersonEmailTwo = $request->input('contactPersonEmailTwo');
        $contactPersonMarkedForSendingRezInfoTwo = $request->input('contactPersonMarkedForSendingRezInfoTwo');
        $contactPersonGivenNameTwo = $request->input('contactPersonGivenNameTwo');
        $contactPersonSurnameTwo = $request->input('contactPersonSurnameTwo');
        $phoneNumberAreaCodeTwo = $request->input('phoneNumberAreaCodeTwo');
        $phoneNumberCountryCodeTwo = $request->input('phoneNumberCountryCodeTwo');
        $phoneNumberMarkedForSendingRezInfoTwo = $request->input('phoneNumberMarkedForSendingRezInfoTwo');
        $phoneNumberSubscriberNumberTwo = $request->input('phoneNumberSubscriberNumberTwo');
        $contactPersonShareMarketIndTwo = $request->input('contactPersonShareMarketIndTwo');
        $contactPersonSocialSecurityNumberTwo = $request->input('contactPersonSocialSecurityNumberTwo');
        $contactPersonShareContactInfoTwo = $request->input('contactPersonShareContactInfoTwo');
        $requestedSeatCountTwo = $request->input('requestedSeatCountTwo');
        $airTravelerListGenderThree = $request->input('airTravelerListGenderThree');
        $airTravelerListBirthDateThree = $request->input('airTravelerListBirthDateThree');
        $passengerTypeCodeThree = $request->input('passengerTypeCodeThree');
        $personNameGivenNameThree = $request->input('personNameGivenNameThree');
        $personNameSurnameThree = $request->input('personNameSurnameThree');
        $contactPersonShareContactInfoThree = $request->input('contactPersonShareContactInfoThree');
        $requestedSeatCountThree = $request->input('requestedSeatCountThree');
        $requestPurposeThree = $request->input('requestPurposeThree');
        $airTravelerSequenceOne = $request->input('airTravelerSequenceOne');
        $flightSegmentSequenceOne = $request->input('flightSegmentSequenceOne');
        $SSRCodeOne = $request->input('SSRCodeOne');
        $SSRExplanationOne = $request->input('SSRExplanationOne');
        $ticketedServiceQuantityOne = $request->input('ticketedServiceQuantityOne');
        $ticketedStatusOne = $request->input('ticketedStatusOne');  
        $airTravelerSequenceTwo = $request->input('airTravelerSequenceTwo');
        $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo');
        $SSRCodeTwo = $request->input('SSRCodeTwo');
        $SSRExplanationTwo = $request->input('SSRExplanationTwo');
        $ticketedServiceQuantityTwo = $request->input('ticketedServiceQuantityTwo');
        $ticketedStatusTwo = $request->input('ticketedStatusTwo'); 

        $xml = $this->createBookingBuilder->createBookingTwoA(
            $actionCode,
            $cabin,
            $airItineraryResBookDesigCode,
            $airItineraryResBookDesigQuantity,
            $airItineraryResBookDesigStatusCode,
            $fareInfoCabin,
            $fareInfoClassCode,
            $fareBaggageAllowanceType,
            $fareBaggageAllowanceMaxAllowedPieces,
            $unitOfMeasureCode,
            $weight,
            $fareGroupName,
            $fareReferenceCode,
            $fareReferenceID,
            $fareReferenceName,
            $fareInfoFlightSegmentSequence,
            $fareInfoPortTax,
            $fareInfoResBookDesigCode,
            $airlineCode,
            $airlineCompanyFullName,
            $arrivalAirportCityLocationCode,
            $arrivalAirportCityLocationName,
            $arrivalAirportCityLocationNameLanguage,
            $arrivalAirportCountryLocationCode,
            $arrivalAirportCountryLocationName,
            $arrivalAirportCountryLocationNameLanguage,
            $arrivalAirportCountryCurrencyCode,
            $arrivalAirportCodeContext,
            $arrivalAirportLanguage,
            $arrivalAirportLocationCode,
            $arrivalAirportLocationName,
            $arrivalAirportTimeZoneInfo,
            $arrivalAirportDateTime,
            $arrivalAirportDateTimeUTC,
            $departureAirportCityLocationCode,
            $departureAirportCityLocationName,
            $departureAirportCityLocationNameLanguage,
            $departureAirportCountryLocationCode,
            $departureAirportCountryLocationName,
            $departureAirportLocationNameLanguage,
            $departureAirportCountryCurrencyCode,
            $departureAirportCodeContext,
            $departureAirportLanguage,
            $departureAirportLocationCode,
            $departureAirportLocationName,
            $departureAirportTimeZoneInfo,
            $departureDateTime,
            $departureDateTimeUTC,
            $flightNumber,
            $flightSegmentID,
            $ondControlled,
            $sector,
            $codeShare,
            $distance,
            $equipmentAirEquipType,
            $equipmentChangeOfGauge,
            $flightNotesDeiCodeOne,
            $flightNotesExplanationOne,
            $flightNotesNoteOne,
            $flightNotesDeiCodeTwo,
            $flightNotesExplanationTwo,
            $flightNotesNoteTwo,
            $flightNotesDeiCodeThree,
            $flightNotesExplanationThree,
            $flightNotesNoteThree,
            $flownMileageQty,
            $iatciFlight,
            $journeyDuration,
            $onTimeRate,
            $remark,
            $secureFlightDataRequired,
            $stopQuantity,
            $ticketType,
            $airTravelerListGenderOne,
            $airTravelerPassengerTypeCodeOne,
            $airTravelerPersonGivenNameOne,
            $airTravelerSurnameOne,
            $airTravelerBirthDateOne,
            $contactPersonEmailOne,
            $emailShareMarketIndOne,
            $contactPersonMarkedForSendingRezInfoOne,
            $personNameGivenNameOne,
            $personNameSurnameOne,
            $contactPersonBirthDateOne,
            $phoneNumberAreaCodeOne,
            $phoneNumberCountryCodeOne,
            $phoneNumberMarkedForSendingRezInfoOne,
            $phoneNumberSubscriberNumberOne,
            $contactPersonShareMarketIndOne,
            $contactPersonSocialSecurityNumberOne,
            $contactPersonShareContactInfoOne,
            $contactPersonRequestedSeatCountOne,
            $airTravelerListGenderTwo,
            $airTravelerPassengerTypeCodeTwo,
            $airTravelerPersonGivenNameTwo,
            $airTravelerSurnameTwo,
            $airTravelerBirthDateTwo,
            $contactPersonEmailTwo,
            $contactPersonMarkedForSendingRezInfoTwo,
            $contactPersonGivenNameTwo,
            $contactPersonSurnameTwo,
            $phoneNumberAreaCodeTwo,
            $phoneNumberCountryCodeTwo,
            $phoneNumberMarkedForSendingRezInfoTwo,
            $phoneNumberSubscriberNumberTwo,
            $contactPersonShareMarketIndTwo,
            $contactPersonSocialSecurityNumberTwo,
            $contactPersonShareContactInfoTwo,
            $requestedSeatCountTwo,
            $airTravelerListGenderThree,
            $airTravelerListBirthDateThree,
            $passengerTypeCodeThree,
            $personNameGivenNameThree,
            $personNameSurnameThree,
            $contactPersonShareContactInfoThree,
            $requestedSeatCountThree,
            $requestPurposeThree,
            $airTravelerSequenceOne,
            $flightSegmentSequenceOne,
            $SSRCodeOne,
            $SSRExplanationOne,
            $ticketedServiceQuantityOne,
            $ticketedStatusOne,  
            $airTravelerSequenceTwo,
            $flightSegmentSequenceTwo,
            $SSRCodeTwo,
            $SSRExplanationTwo,
            $ticketedServiceQuantityTwo,
            $ticketedStatusTwo
        );

        dd($xml);
    }

  
}
