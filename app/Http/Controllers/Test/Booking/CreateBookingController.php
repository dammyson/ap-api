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
        $bookingFlightActionCode = $request->input('bookingFlightActionCode');
        $bookingFlightCabin = $request->input('bookingFlightCabin');
        $bookingFlightResBookDesigCode = $request->input('bookingFlightResBookDesigCode');
        $bookingFlightResBookDesigQuantity = $request->input('bookingFlightResBookDesigQuantity');
        $bookingFlightResBookDesigStatusCode = $request->input('bookingFlightResBookDesigStatusCode');
        $fareInfoCabin = $request->input('fareInfoCabin');
        $fareInfoCabinClassCode = $request->input('fareInfoCabinClassCode');
        $bookingFlightFareBaggageAllowanceType = $request->input('bookingFlightFareBaggageAllowanceType');
        $bookingFlightFareBaggageMaxAllowedPieces = $request->input('bookingFlightFareBaggageMaxAllowedPieces');
        $unitOfMeasureCode = $request->input('unitOfMeasureCode');
        $fareInfoMaxAllowedWeight = $request->input('fareInfoMaxAllowedWeight');
        $fareInfoFareGroupName = $request->input('fareInfoFareGroupName');
        $fareInfoFareReferenceCode = $request->input('fareInfoFareReferenceCode');
        $fareInfoFareReferenceID = $request->input('fareInfoFareReferenceID');
        $fareInfoFareReferenceName = $request->input('fareInfoFareReferenceName');
        $fareInfoFlightSegmentSequence = $request->input('fareInfoFlightSegmentSequence');
        $fareInfoPortTax = $request->input('fareInfoPortTax');
        $resBookDesigCode = $request->input('resBookDesigCode');
        $flightSegmentCode = $request->input('flightSegmentCode');
        $flightSegmentCompanyFullName = $request->input('flightSegmentCompanyFullName');
        $arrivalAirporCityLocationCodeOne = $request->input('arrivalAirporCityLocationCodeOne');
        $arrivalAirportCityLocationNameOne = $request->input('arrivalAirportCityLocationNameOne');
        $arrivalAirportCityLocationNameLanguageOne = $request->input('arrivalAirportCityLocationNameLanguageOne'); 
        $arrivalAirportCountryLocationCodeOne = $request->input('arrivalAirportCountryLocationCodeOne');
        $arrivalAirportCountryLocationNameOne = $request->input('arrivalAirportCountryLocationNameOne');
        $arrivalAirportCountryLocationNameLanguageOne = $request->input('arrivalAirportCountryLocationNameLanguageOne');
        $arrivalAirportCurrencyCodeOne = $request->input('arrivalAirportCurrencyCodeOne');
        $arrivalAirportCodeContextOne = $request->input('arrivalAirportCodeContextOne');
        $arrivalAirportLanguageOne = $request->input('arrivalAirportLanguageOne');
        $arrivalAirportLocationCodeOne = $request->input('arrivalAirportLocationCodeOne');
        $arrivalAirportLocationNameOne = $request->input('arrivalAirportLocationNameOne');
        $arrivalAirportTimeZoneInfoOne = $request->input('arrivalAirportTimeZoneInfoOne');
        $arrivalDateTimeOne = $request->input('arrivalDateTimeOne');
        $arrivalDateTimeUTCOne = $request->input('arrivalDateTimeUTCOne');
        $departureAirportCityLocationCodeOne = $request->input('departureAirportCityLocationCodeOne');
        $departureAirportCityLocationNameOne = $request->input('departureAirportCityLocationNameOne');
        $departureAirportCityLocationNameLanguageOne = $request->input('departureAirportCityLocationNameLanguageOne');
        $departureAirportCountryLocationCodeOne = $request->input('departureAirportCountryLocationCodeOne');
        $departureAirportCountryLocationNameOne = $request->input('departureAirportCountryLocationNameOne');
        $departureAirportCountryLocationNameLanguageOne = $request->input('departureAirportCountryLocationNameLanguageOne');
        $departureAirportCountryCurrencyCodeOne = $request->input('departureAirportCountryCurrencyCodeOne');
        $departureAirportCodeContextOne = $request->input('departureAirportCodeContextOne');
        $departureAirportLanguageOne = $request->input('departureAirportLanguageOne');
        $departureAirportLocationCodeOne = $request->input('departureAirportLocationCodeOne');
        $departureAirportLocationNameOne = $request->input('departureAirportLocationNameOne');
        $departureAirportTimeZoneInfoOne = $request->input('departureAirportTimeZoneInfoOne');
        $departureDateTimeOne = $request->input('departureDateTimeOne');
        $departureDateTimeUTCOne = $request->input('departureDateTimeUTCOne');
        $flightNumberOne = $request->input('flightNumberOne');
        $flightSegmentIDOne = $request->input('flightSegmentIDOne');
        $ondControlledOne = $request->input('ondControlledOne');
        $sectorOne = $request->input('sectorOne');
        $codeShareOne = $request->input('codeShareOne');
        $distanceOne = $request->input('distanceOne');
        $equipmentAirEquipType = $request->input('equipmentAirEquipType');
        $equipmentChangeOfGauge = $request->input('equipmentChangeOfGauge');
        $flightNotesDeiCodeOne = $request->input('flightNotesDeiCodeOne');
        $flightNotesExplanationOne = $request->input('flightNotesExplanationOne');
        $flightNotesNoteOne = $request->input('flightNotesNoteOne');
        $flightNotesDeiCodeTwo = $request->input('flightNotesDeiCodeTwo');
        $flightNotesExplanationTwo = $request->input('flightNotesExplanationTwo');
        $flightNotesNoteTwo = $request->input('flightNotesNoteTwo');
        $flightNoteDeiCodeThree = $request->input('flightNoteDeiCodeThree');
        $flightNotesExplanationThree = $request->input('flightNotesExplanationThree');
        $flightNotesNoteThree = $request->input('flightNotesNoteThree');
        $flownMileageQty = $request->input('flownMileageQty');
        $iatciFlight = $request->input('iatciFlight');
        $journeyDurationOne = $request->input('journeyDurationOne');
        $onTimeRateOne = $request->input('onTimeRateOne');
        $flightSegmentRemark = $request->input('flightSegmentRemark');
        $secureFlightDataRequired = $request->input('secureFlightDataRequired');
        $stopQuantityOne = $request->input('stopQuantityOne');
        $ticketTypeOne = $request->input('ticketTypeOne');
        $bookingFlightSegmentActionCodeTwo = $request->input('bookingFlightSegmentActionCodeTwo');
        $bookingClassCabinTwo = $request->input('bookingClassCabinTwo');
        $bookingClassResBookDesigCodeTwo = $request->input('bookingClassResBookDesigCodeTwo');
        $bookingClassResBookDesigQuantityTwo = $request->input('bookingClassResBookDesigQuantityTwo');
        $bookingClassResBookDesigStatusCodeTwo = $request->input('bookingClassResBookDesigStatusCodeTwo');
        $fareInfoCabinTwo = $request->input('fareInfoCabinTwo');
        $fareInfoCabinClassCodeTwo = $request->input('fareInfoCabinClassCodeTwo');
        $fareBaggageAllowanceTypeTwo = $request->input('fareBaggageAllowanceTypeTwo');
        $fareBaggageMaxAllowedPiecesTwo = $request->input('fareBaggageMaxAllowedPiecesTwo');
        $maxAllowedWeightUnitOfMeasureCodeTwo = $request->input('maxAllowedWeightUnitOfMeasureCodeTwo');
        $maxAllowedWeightTwo = $request->input('maxAllowedWeightTwo');
        $fareGroupNameTwo = $request->input('fareGroupNameTwo');
        $fareReferenceCodeTwo = $request->input('fareReferenceCodeTwo');
        $fareReferenceIDTwo = $request->input('fareReferenceIDTwo');
        $fareReferenceNameTwo = $request->input('fareReferenceNameTwo');
        $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo');
        $portTaxTwo = $request->input('portTaxTwo');
        $fareInfoResBookDesigCodeTwo = $request->input('fareInfoResBookDesigCodeTwo');
        $airlineCodeTwo = $request->input('airlineCodeTwo');
        $airlineCompanyFullNameTwo = $request->input('airlineCompanyFullNameTwo');
        $arrivalAirportCityLocationCodeTwo = $request->input('arrivalAirportCityLocationCodeTwo');
        $arrivalAirportCityLocationNameTwo = $request->input('arrivalAirportCityLocationNameTwo');
        $arrivalAirportCityLocationNameLanguageTwo = $request->input('arrivalAirportCityLocationNameLanguageTwo'); 
        $arrivalAirportCountryLocationCodeTwo = $request->input('arrivalAirportCountryLocationCodeTwo');
        $arrivalAirportCountryLocationNameTwo = $request->input('arrivalAirportCountryLocationNameTwo');
        $arrivalAirportCountryLocationNameLanguageTwo = $request->input('arrivalAirportCountryLocationNameLanguageTwo');
        $arrivalAirportCurrencyCodeTwo = $request->input('arrivalAirportCurrencyCodeTwo');
        $arrivalAirportCodeContextTwo = $request->input('arrivalAirportCodeContextTwo');
        $arrivalAirportLanguageTwo = $request->input('arrivalAirportLanguageTwo');
        $arrivalAirportLocationCodeTwo = $request->input('arrivalAirportLocationCodeTwo');
        $arrivalAirportLocationNameTwo = $request->input('arrivalAirportLocationNameTwo');
        $arrivalAirportTimeZoneInfoTwo = $request->input('arrivalAirportTimeZoneInfoTwo');
        $arrivalDateTimeTwo = $request->input('arrivalDateTimeTwo');
        $arrivalDateTimeUTCTwo = $request->input('arrivalDateTimeUTCTwo');
        $departureAirportCityLocationCodeTwo = $request->input('departureAirportCityLocationCodeTwo');
        $departureAirportCityInfoLocationNameTwo = $request->input('departureAirportCityInfoLocationNameTwo');
        $departureAirportCityLocationNameLanguageTwo = $request->input('departureAirportCityLocationNameLanguageTwo');
        $departureAirportCountryLocationCodeTwo = $request->input('departureAirportCountryLocationCodeTwo');
        $departureAirportCountryLocationNameTwo = $request->input('departureAirportCountryLocationNameTwo');
        $departureAirportCountryLocationNameLanguageTwo = $request->input('departureAirportCountryLocationNameLanguageTwo');
        $deparutureAirportCountryCurrencyCodeTwo = $request->input('deparutureAirportCountryCurrencyCodeTwo');
        $departureAirportCodeContextTwo = $request->input('departureAirportCodeContextTwo');
        $departureAirportLanguageTwo = $request->input('departureAirportLanguageTwo');
        $departureAirportLocationCodeTwo = $request->input('departureAirportLocationCodeTwo');
        $departureAirportLocationNameTwo = $request->input('departureAirportLocationNameTwo');
        $departureAirportTimeZoneInfoTwo = $request->input('departureAirportTimeZoneInfoTwo');
        $departureDateTimeTwo = $request->input('departureDateTimeTwo');
        $departureDateTimeUTCTwo = $request->input('departureDateTimeUTCTwo');
        $flightNumberTwo = $request->input('flightNumberTwo');
        $flightSegmentIDTwo = $request->input('flightSegmentIDTwo');
        $ondControlledTwo = $request->input('ondControlledTwo');
        $sectorTwo = $request->input('sectorTwo');
        $codeshareTwo = $request->input('codeshareTwo');
        $distanceTwo = $request->input('distanceTwo');
        $airEquipTypeTwo = $request->input('airEquipTypeTwo');
        $changeOfGuageTwo = $request->input('changeOfGuageTwo');
        $flightNotesDeiCodeFour = $request->input('flightNotesDeiCodeFour');
        $flightNotesExplanationFour = $request->input('flightNotesExplanationFour');
        $flightNotesNoteFour = $request->input('flightNotesNoteFour');
        $flightNotesDeiCodeFive = $request->input('flightNotesDeiCodeFive');
        $flightNotesExplanationFive = $request->input('flightNotesExplanationFive');
        $flightNotesNoteFive = $request->input('flightNotesNoteFive');
        $flownMileageQtyTwo = $request->input('flownMileageQtyTwo');
        $iatciFlightTwo = $request->input('iatciFlightTwo');
        $journeyDurationTwo = $request->input('journeyDurationTwo');
        $onTimeRateTwo = $request->input('onTimeRateTwo');
        $secureFlightDataRequiredTwo = $request->input('secureFlightDataRequiredTwo');
        $stopQuantityTwo = $request->input('stopQuantityTwo');
        $ticketTypeTwo = $request->input('ticketTypeTwo');
        $airTravelerListGenderTwo = $request->input('airTravelerListGenderTwo');
        $airTravelerListPassengerTypeCodeTwo = $request->input('airTravelerListPassengerTypeCodeTwo');
        $airTravelerListPersonNameGivenNameTwo = $request->input('airTravelerListPersonNameGivenNameTwo');
        $airTravelerListSurnameTwo = $request->input('airTravelerListSurnameTwo');
        $airTravelerListBirthDateTwo = $request->input('airTravelerListBirthDateTwo');
        $contactPersonEmail = $request->input('contactPersonEmail');
        $contactPersonShareMarketInd = $request->input('contactPersonShareMarketInd');
        $contactPersonMarkedForSendingRezInfo = $request->input('contactPersonMarkedForSendingRezInfo');
        $contactPersonPersonNameGivenName = $request->input('contactPersonPersonNameGivenName');
        $contactPersonPersonNameSurname = $request->input('contactPersonPersonNameSurname');
        $phoneNumberAreaCode = $request->input('phoneNumberAreaCode');
        $phoneNumberCountryCode = $request->input('phoneNumberCountryCode');
        $phoneNumberMarkedForSendingRezInfo = $request->input('phoneNumberMarkedForSendingRezInfo');
        $phoneNumberSubscriberNumber = $request->input('phoneNumberSubscriberNumber');
        $phoneNumberShareMarketInd = $request->input('phoneNumberShareMarketInd');
        $phoneNumberSocialSecurityNumber = $request->input('phoneNumberSocialSecurityNumber');
        $shareContactInfo = $request->input('shareContactInfo');
        $requestedSeatCount = $request->input('requestedSeatCount');
        $requestPurpose = $request->input('requestPurpose');
        $capturePayment = $request->input('capturePayment');
        $paymentCode = $request->input('paymentCode');
        $threeDomainSecurityEligible = $request->input('threeDomainSecurityEligible');
        $MCONumber = $request->input('MCONumber');
        $paymentAmountCurrencyCode = $request->input('paymentAmountCurrencyCode');
        $paymentType = $request->input('paymentType');
        $primaryPayment = $request->input('primaryPayment');

        $xml = $this->createBookingBuilder->createBookingRT(
            $bookingFlightActionCode,
            $bookingFlightCabin,
            $bookingFlightResBookDesigCode,
            $bookingFlightResBookDesigQuantity,
            $bookingFlightResBookDesigStatusCode,
            $fareInfoCabin,
            $fareInfoCabinClassCode,
            $bookingFlightFareBaggageAllowanceType,
            $bookingFlightFareBaggageMaxAllowedPieces,
            $unitOfMeasureCode,
            $fareInfoMaxAllowedWeight,
            $fareInfoFareGroupName,
            $fareInfoFareReferenceCode,
            $fareInfoFareReferenceID,
            $fareInfoFareReferenceName,
            $fareInfoFlightSegmentSequence,
            $fareInfoPortTax,
            $resBookDesigCode,
            $flightSegmentCode,
            $flightSegmentCompanyFullName,
            $arrivalAirporCityLocationCodeOne,
            $arrivalAirportCityLocationNameOne,
            $arrivalAirportCityLocationNameLanguageOne, 
            $arrivalAirportCountryLocationCodeOne,
            $arrivalAirportCountryLocationNameOne,
            $arrivalAirportCountryLocationNameLanguageOne,
            $arrivalAirportCurrencyCodeOne,
            $arrivalAirportCodeContextOne,
            $arrivalAirportLanguageOne,
            $arrivalAirportLocationCodeOne,
            $arrivalAirportLocationNameOne,
            $arrivalAirportTimeZoneInfoOne,
            $arrivalDateTimeOne,
            $arrivalDateTimeUTCOne,
            $departureAirportCityLocationCodeOne,
            $departureAirportCityLocationNameOne,
            $departureAirportCityLocationNameLanguageOne,
            $departureAirportCountryLocationCodeOne,
            $departureAirportCountryLocationNameOne,
            $departureAirportCountryLocationNameLanguageOne,
            $departureAirportCountryCurrencyCodeOne,
            $departureAirportCodeContextOne,
            $departureAirportLanguageOne,
            $departureAirportLocationCodeOne,
            $departureAirportLocationNameOne,
            $departureAirportTimeZoneInfoOne,
            $departureDateTimeOne,
            $departureDateTimeUTCOne,
            $flightNumberOne,
            $flightSegmentIDOne,
            $ondControlledOne,
            $sectorOne,
            $codeShareOne,
            $distanceOne,
            $equipmentAirEquipType,
            $equipmentChangeOfGauge,
            $flightNotesDeiCodeOne,
            $flightNotesExplanationOne,
            $flightNotesNoteOne,
            $flightNotesDeiCodeTwo,
            $flightNotesExplanationTwo,
            $flightNotesNoteTwo,
            $flightNoteDeiCodeThree,
            $flightNotesExplanationThree,
            $flightNotesNoteThree,
            $flownMileageQty,
            $iatciFlight,
            $journeyDurationOne,
            $onTimeRateOne,
            $flightSegmentRemark,
            $secureFlightDataRequired,
            $stopQuantityOne,
            $ticketTypeOne,
            $bookingFlightSegmentActionCodeTwo,
            $bookingClassCabinTwo,
            $bookingClassResBookDesigCodeTwo,
            $bookingClassResBookDesigQuantityTwo,
            $bookingClassResBookDesigStatusCodeTwo,
            $fareInfoCabinTwo,
            $fareInfoCabinClassCodeTwo,
            $fareBaggageAllowanceTypeTwo,
            $fareBaggageMaxAllowedPiecesTwo,
            $maxAllowedWeightUnitOfMeasureCodeTwo,
            $maxAllowedWeightTwo,
            $fareGroupNameTwo,
            $fareReferenceCodeTwo,
            $fareReferenceIDTwo,
            $fareReferenceNameTwo,
            $flightSegmentSequenceTwo,
            $portTaxTwo,
            $fareInfoResBookDesigCodeTwo,
            $airlineCodeTwo,
            $airlineCompanyFullNameTwo,
            $arrivalAirportCityLocationCodeTwo,
            $arrivalAirportCityLocationNameTwo,
            $arrivalAirportCityLocationNameLanguageTwo, 
            $arrivalAirportCountryLocationCodeTwo,
            $arrivalAirportCountryLocationNameTwo,
            $arrivalAirportCountryLocationNameLanguageTwo,
            $arrivalAirportCurrencyCodeTwo,
            $arrivalAirportCodeContextTwo,
            $arrivalAirportLanguageTwo,
            $arrivalAirportLocationCodeTwo,
            $arrivalAirportLocationNameTwo,
            $arrivalAirportTimeZoneInfoTwo,
            $arrivalDateTimeTwo,
            $arrivalDateTimeUTCTwo,
            $departureAirportCityLocationCodeTwo,
            $departureAirportCityInfoLocationNameTwo,
            $departureAirportCityLocationNameLanguageTwo,
            $departureAirportCountryLocationCodeTwo,
            $departureAirportCountryLocationNameTwo,
            $departureAirportCountryLocationNameLanguageTwo,
            $deparutureAirportCountryCurrencyCodeTwo,
            $departureAirportCodeContextTwo,
            $departureAirportLanguageTwo,
            $departureAirportLocationCodeTwo,
            $departureAirportLocationNameTwo,
            $departureAirportTimeZoneInfoTwo,
            $departureDateTimeTwo,
            $departureDateTimeUTCTwo,
            $flightNumberTwo,
            $flightSegmentIDTwo,
            $ondControlledTwo,
            $sectorTwo,
            $codeshareTwo,
            $distanceTwo,
            $airEquipTypeTwo,
            $changeOfGuageTwo,
            $flightNotesDeiCodeFour,
            $flightNotesExplanationFour,
            $flightNotesNoteFour,
            $flightNotesDeiCodeFive,
            $flightNotesExplanationFive,
            $flightNotesNoteFive,
            $flownMileageQtyTwo,
            $iatciFlightTwo,
            $journeyDurationTwo,
            $onTimeRateTwo,
            $secureFlightDataRequiredTwo,
            $stopQuantityTwo,
            $ticketTypeTwo,
            $airTravelerListGenderTwo,
            $airTravelerListPassengerTypeCodeTwo,
            $airTravelerListPersonNameGivenNameTwo,
            $airTravelerListSurnameTwo,
            $airTravelerListBirthDateTwo,
            $contactPersonEmail,
            $contactPersonShareMarketInd,
            $contactPersonMarkedForSendingRezInfo,
            $contactPersonPersonNameGivenName,
            $contactPersonPersonNameSurname,
            $phoneNumberAreaCode,
            $phoneNumberCountryCode,
            $phoneNumberMarkedForSendingRezInfo,
            $phoneNumberSubscriberNumber,
            $phoneNumberShareMarketInd,
            $phoneNumberSocialSecurityNumber,
            $shareContactInfo,
            $requestedSeatCount,
            $requestPurpose,
            $capturePayment,
            $paymentCode,
            $threeDomainSecurityEligible,
            $MCONumber,
            $paymentAmountCurrencyCode,
            $paymentType,
            $primaryPayment
        );

        dd($xml);
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

    public function createBookingOW(createBookingOWRequest $request) {
        $actionCode = $request->input('actionCode');
        $bookingClassCabin = $request->input('bookingClassCabin');
        $bookingClassResBookDesigCode = $request->input('bookingClassResBookDesigCode');
        $bookingClassResBookDesigQuantity = $request->input('bookingClassResBookDesigQuantity');
        $bookingClassResBookDesigStatusCode = $request->input('bookingClassResBookDesigStatusCode');
        $fareInfoCabin = $request->input('fareInfoCabin');
        $fareInfoCabinClassCode = $request->input('fareInfoCabinClassCode');
        $fareBaggageAllowanceType = $request->input('fareBaggageAllowanceType');
        $fareBaggageMaxAllowedPieces = $request->input('fareBaggageMaxAllowedPieces');
        $unitOfMeasureCode = $request->input('unitOfMeasureCode');
        $maxAllowedWeight = $request->input('maxAllowedWeight');
        $fareGroupName = $request->input('fareGroupName');
        $fareReferenceCode = $request->input('fareReferenceCode');
        $fareReferenceID = $request->input('fareReferenceID');
        $fareReferenceName = $request->input('fareReferenceName');
        $flightSegmeneSequence = $request->input('flightSegmeneSequence');
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
        $arrivalAirportCountryCode = $request->input('arrivalAirportCountryCode');
        $arrivalAirportCodeContext = $request->input('arrivalAirportCodeContext');
        $arrivalAirportLanguage = $request->input('arrivalAirportLanguage');
        $arrivalAirportLocationCode = $request->input('arrivalAirportLocationCode');
        $arrivalAirportLocationName = $request->input('arrivalAirportLocationName');
        $arrivalAirportTimeZoneInfo = $request->input('arrivalAirportTimeZoneInfo');
        $arrivalDateTime = $request->input('arrivalDateTime');
        $arrivalDateTimeUTC = $request->input('arrivalDateTimeUTC');
        $departureAirportCityLocationCode = $request->input('departureAirportCityLocationCode');
        $departureAirportCityLocationName = $request->input('departureAirportCityLocationName');
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountryLocationCode = $request->input('departureAirportCountryLocationCode');
        $departureAirportCountryLocationName = $request->input('departureAirportCountryLocationName');
        $departureAirportCountryLocationNameLanguage = $request->input('departureAirportCountryLocationNameLanguage');
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
        $codeshare = $request->input('codeshare');
        $distance = $request->input('distance');
        $airEquipType = $request->input('airEquipType');
        $changeOfGuage = $request->input('changeOfGuage');
        $flightNotesDeiCodeOne = $request->input('flightNotesDeiCodeOne');
        $flightNotesExplanationOne = $request->input('flightNotesExplanationOne');
        $flightNoteOne = $request->input('flightNoteOne');
        $flightNotesDeiCodeTwo = $request->input('flightNotesDeiCodeTwo');
        $flightNotesExplanationTwo = $request->input('flightNotesExplanationTwo');
        $flightNotesNoteTwo = $request->input('flightNotesNoteTwo');
        $flightNoteDeiCodeThree = $request->input('flightNoteDeiCodeThree');
        $flightNoteExplanationThree = $request->input('flightNoteExplanationThree');
        $flightNotesNoteThree = $request->input('flightNotesNoteThree');
        $flownMileageQty = $request->input('flownMileageQty');
        $iatciFlight = $request->input('iatciFlight');
        $journeyDuration = $request->input('journeyDuration');
        $onTimeRate = $request->input('onTimeRate');
        $remark = $request->input('remark');
        $secureFlightDataRequired = $request->input('secureFlightDataRequired');
        $stopQuantity = $request->input('stopQuantity');
        $ticketType = $request->input('ticketType');
        $airTravelerListGender = $request->input('airTravelerListGender');
        $airTravelerPassengerTypeCode = $request->input('airTravelerPassengerTypeCode');
        $airTravelerListGivenName = $request->input('airTravelerListGivenName');
        $airTravelerListSurname = $request->input('airTravelerListSurname');
        $airTravelerBirthDate = $request->input('airTravelerBirthDate');
        $contactPersonEmail = $request->input('contactPersonEmail');
        $contactPersonShareMarketInd = $request->input('contactPersonShareMarketInd');
        $contactPersonMarkedForSendingRezInfo = $request->input('contactPersonMarkedForSendingRezInfo');
        $contactPersonNameGivenName = $request->input('contactPersonNameGivenName');
        $contactPersonSurname = $request->input('contactPersonSurname');
        $phoneNumberAreaCode = $request->input('phoneNumberAreaCode');
        $phoneNumberCountryCode = $request->input('phoneNumberCountryCode');
        $phoneNumberMarkedForSendingRezInfo = $request->input('phoneNumberMarkedForSendingRezInfo');
        $phoneNumberSubscriberNumber = $request->input('phoneNumberSubscriberNumber');
        $shareMarketInd = $request->input('shareMarketInd');
        $contactPersonSocialSecurityNumber = $request->input('contactPersonSocialSecurityNumber');
        $shareContactInfo = $request->input('shareContactInfo');
        $requestedSeatCount = $request->input('requestedSeatCount');
        $requestPurpose = $request->input('requestPurpose');


        $xml = $this->createBookingBuilder->createBookingOW(
            $actionCode,
            $bookingClassCabin,
            $bookingClassResBookDesigCode,
            $bookingClassResBookDesigQuantity,
            $bookingClassResBookDesigStatusCode,
            $fareInfoCabin,
            $fareInfoCabinClassCode,
            $fareBaggageAllowanceType,
            $fareBaggageMaxAllowedPieces,
            $unitOfMeasureCode,
            $maxAllowedWeight,
            $fareGroupName,
            $fareReferenceCode,
            $fareReferenceID,
            $fareReferenceName,
            $flightSegmeneSequence,
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
            $arrivalAirportCountryCode,
            $arrivalAirportCodeContext,
            $arrivalAirportLanguage,
            $arrivalAirportLocationCode,
            $arrivalAirportLocationName,
            $arrivalAirportTimeZoneInfo,
            $arrivalDateTime,
            $arrivalDateTimeUTC,
            $departureAirportCityLocationCode,
            $departureAirportCityLocationName,
            $departureAirportCityLocationNameLanguage,
            $departureAirportCountryLocationCode,
            $departureAirportCountryLocationName,
            $departureAirportCountryLocationNameLanguage,
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
            $codeshare,
            $distance,
            $airEquipType,
            $changeOfGuage,
            $flightNotesDeiCodeOne,
            $flightNotesExplanationOne,
            $flightNoteOne,
            $flightNotesDeiCodeTwo,
            $flightNotesExplanationTwo,
            $flightNotesNoteTwo,
            $flightNoteDeiCodeThree,
            $flightNoteExplanationThree,
            $flightNotesNoteThree,
            $flownMileageQty,
            $iatciFlight,
            $journeyDuration,
            $onTimeRate,
            $remark,
            $secureFlightDataRequired,
            $stopQuantity,
            $ticketType,
            $airTravelerListGender,
            $airTravelerPassengerTypeCode,
            $airTravelerListGivenName,
            $airTravelerListSurname,
            $airTravelerBirthDate,
            $contactPersonEmail,
            $contactPersonShareMarketInd,
            $contactPersonMarkedForSendingRezInfo,
            $contactPersonNameGivenName,
            $contactPersonSurname,
            $phoneNumberAreaCode,
            $phoneNumberCountryCode,
            $phoneNumberMarkedForSendingRezInfo,
            $phoneNumberSubscriberNumber,
            $shareMarketInd,
            $contactPersonSocialSecurityNumber,
            $shareContactInfo,
            $requestedSeatCount,
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
}
