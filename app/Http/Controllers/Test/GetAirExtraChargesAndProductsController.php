<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Soap\GetAirExtraChargesAndProductBuilder;
use App\Http\Requests\Test\GetExtraChargesAndProductMDRequest;
use App\Http\Requests\Test\GetExtraChargesAndProductOWRequest;
use App\Http\Requests\Test\GetExtraChargesAndProductRtRequest;
use App\Http\Requests\Test\GetExtraChargesAndProductTwoARequest;
use App\Http\Requests\Test\GetAvailability\GetAvailabilityOWRequest;

class GetAirExtraChargesAndProductsController extends Controller
{
    protected $getAirExtraChargesAndProductBuilder;

    public function __construct(GetAirExtraChargesAndProductBuilder $getAirExtraChargesAndProductBuilder)
    {
        $this->getAirExtraChargesAndProductBuilder = $getAirExtraChargesAndProductBuilder;
    }


    public function getAirExtraChargesAndProductRT(GetExtraChargesAndProductRtRequest $request) {
        $bookingClassCabinOne = $request->input('bookingClassCabinOne'); 
        $bookingClassResBookDesigCodeOne = $request->input('bookingClassResBookDesigCodeOne'); 
        $bookingClassResBookDesigQuantityOne = $request->input('bookingClassResBookDesigQuantityOne'); 
        $bookingClassResBookDesigStatusCodeOne = $request->input('bookingClassResBookDesigStatusCodeOne');
        $fareInfoCabinOne = $request->input('fareInfoCabinOne'); 
        $fareInfoCabinClassCodeOne = $request->input('fareInfoCabinClassCodeOne'); 
        $fareBaggageAllowanceTypeOne = $request->input('fareBaggageAllowanceTypeOne'); 
        $fareBaggageMaxAllowedPiecesOne = $request->input('fareBaggageMaxAllowedPiecesOne'); 
        $unitOfMeasureCodeOne = $request->input('unitOfMeasureCodeOne'); 
        $weightOne = $request->input('weightOne');
        $fareGroupNameOne = $request->input('fareGroupNameOne'); 
        $fareReferenceCodeOne = $request->input('fareReferenceCodeOne'); 
        $fareReferenceIDOne = $request->input('fareReferenceIDOne'); 
        $fareReferenceNameOne = $request->input('fareReferenceNameOne'); 
        $flightSegmentSequenceOne = $request->input('flightSegmentSequenceOne');
        $portTaxOne = $request->input('portTaxOne'); 
        $fareInfoResBookDesigCodeOne = $request->input('fareInfoResBookDesigCodeOne');
        $airlineCodeOne = $request->input('airlineCodeOne'); 
        $companyFullNameOne = $request->input('companyFullNameOne'); 
        $arrivalAirportCityLocationCodeOne = $request->input('arrivalAirportCityLocationCodeOne'); 
        $arrivalAirportCityLocationNameOne = $request->input('arrivalAirportCityLocationNameOne'); 
        $arrivalAirportCityLocationNameLanguageOne = $request->input('arrivalAirportCityLocationNameLanguageOne'); 
        $arrivalAirportCountryLocationCodeOne = $request->input('arrivalAirportCountryLocationCodeOne');
        $arrivalAirportCountryLocationNameOne = $request->input('arrivalAirportCountryLocationNameOne'); 
        $arrivalAirportCountryLocationNameLangaugeOne = $request->input('arrivalAirportCountryLocationNameLangaugeOne'); 
        $arrivalAirportCountryCurrencyCodeOne = $request->input('arrivalAirportCountryCurrencyCodeOne'); 
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
        $departureCountryLocationNameOne = $request->input('departureCountryLocationNameOne'); 
        $departureCountryLocationNameLanguageOne = $request->input('departureCountryLocationNameLanguageOne');
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
        $airEquipTypeOne = $request->input('airEquipTypeOne'); 
        $changeOfGaugeOne = $request->input('changeOfGaugeOne'); 
        $flightNotesDeiCodeOne = $request->input('flightNotesDeiCodeOne'); 
        $flightNoteExplanationOne = $request->input('flightNoteExplanationOne'); 
        $flightNotesNoteOne = $request->input('flightNotesNoteOne');
        $flightNotesDeiCodeTwo = $request->input('flightNotesDeiCodeTwo'); 
        $flightExplanationTwo = $request->input('flightExplanationTwo'); 
        $flightNotesNoteTwo = $request->input('flightNotesNoteTwo'); 
        $flightNoteDeiCodeThree = $request->input('flightNoteDeiCodeThree'); 
        $flightNotesExplanationThree = $request->input('flightNotesExplanationThree'); 
        $flightNotesNoteThree = $request->input('flightNotesNoteThree');
        $flownMileageQtyOne = $request->input('flownMileageQtyOne'); 
        $iatciFlightOne = $request->input('iatciFlightOne'); 
        $journeyDurationOne = $request->input('journeyDurationOne'); 
        $onTimeRateOne = $request->input('onTimeRateOne'); 
        $remarkOne = $request->input('remarkOne'); 
        $secureFlightDataRequiredOne = $request->input('secureFlightDataRequiredOne'); 
        $stopQuantityOne = $request->input('stopQuantityOne'); 
        $ticketTypeOne = $request->input('ticketTypeOne');
        $bookingClassCabinTwo = $request->input('bookingClassCabinTwo');
        $bookingClassResBookDesigCodeTwo = $request->input('bookingClassResBookDesigCodeTwo');
        $bookingClassResBookDesigQuantityTwo = $request->input('bookingClassResBookDesigQuantityTwo'); 
        $bookingClassResBookDesigStatusCodeTwo = $request->input('bookingClassResBookDesigStatusCodeTwo');
        $fareInfoCabinTwo = $request->input('fareInfoCabinTwo'); 
        $fareInfoCabinClassCodeTwo = $request->input('fareInfoCabinClassCodeTwo'); 
        $fareBaggageAllowedTypeTwo = $request->input('fareBaggageAllowedTypeTwo'); 
        $fareBaggageMaxAllowedPiecesTwo = $request->input('fareBaggageMaxAllowedPiecesTwo'); 
        $unitOfMeasureCodeTwo = $request->input('unitOfMeasureCodeTwo'); 
        $weightTwo = $request->input('weightTwo');
        $fareGroupNameTwo = $request->input('fareGroupNameTwo'); 
        $fareReferenceCodeTwo = $request->input('fareReferenceCodeTwo'); 
        $fareReferenceIDTwo = $request->input('fareReferenceIDTwo'); 
        $fareReferenceNameTwo = $request->input('fareReferenceNameTwo'); 
        $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo');
        $portTaxTwo = $request->input('portTaxTwo'); 
        $fareInfoResBookDesigCodeTwo = $request->input('fareInfoResBookDesigCodeTwo');
        $airlineCodeTwo = $request->input('airlineCodeTwo'); 
        $companyFullNameTwo = $request->input('companyFullNameTwo'); 
        $arrivalAirportCityLocationCodeTwo = $request->input('arrivalAirportCityLocationCodeTwo'); 
        $arrivalAirportCityLocationNameTwo = $request->input('arrivalAirportCityLocationNameTwo'); 
        $arrivalAirportCityLocationNameLanguageTwo = $request->input('arrivalAirportCityLocationNameLanguageTwo'); 
        $arrivalAirportCountryLocationCodeTwo = $request->input('arrivalAirportCountryLocationCodeTwo');
        $arrivalAirportCountryLocatoinNameTwo = $request->input('arrivalAirportCountryLocatoinNameTwo'); 
        $arrivalAirportCountryLocationNameLangaugeTwo = $request->input('arrivalAirportCountryLocationNameLangaugeTwo'); 
        $arrivalAirportCountryCurrencyCodeTwo = $request->input('arrivalAirportCountryCurrencyCodeTwo'); 
        $arrivalAirportCodeContextTwo = $request->input('arrivalAirportCodeContextTwo'); 
        $arrivalAirportLanguageTwo = $request->input('arrivalAirportLanguageTwo');
        $arrivalAirportLocationCodeTwo = $request->input('arrivalAirportLocationCodeTwo'); 
        $arrivalAirportLocationNameTwo = $request->input('arrivalAirportLocationNameTwo'); 
        $arrivalAirportTimeZoneInfoTwo = $request->input('arrivalAirportTimeZoneInfoTwo'); 
        $arrivalDateTimeTwo = $request->input('arrivalDateTimeTwo'); 
        $arrivalDateTimeUTCTwo = $request->input('arrivalDateTimeUTCTwo');
        $departureAirportCityLocationCodeTwo = $request->input('departureAirportCityLocationCodeTwo'); 
        $departureAirportCityLocationNameTwo = $request->input('departureAirportCityLocationNameTwo'); 
        $departureAirportCityLocationNameLanguageTwo = $request->input('departureAirportCityLocationNameLanguageTwo'); 
        $departureAirportCountryLocationCodeTwo = $request->input('departureAirportCountryLocationCodeTwo'); 
        $departureCountryLocationNameTwo = $request->input('departureCountryLocationNameTwo'); 
        $departureCountryLocationNameLanguageTwo = $request->input('departureCountryLocationNameLanguageTwo');
        $departureAirportCountryCurrencyCodeTwo = $request->input('departureAirportCountryCurrencyCodeTwo'); 
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
        $codeShareTwo = $request->input('codeShareTwo'); 
        $distanceTwo = $request->input('distanceTwo'); 
        $airEquipTypeTwo = $request->input('airEquipTypeTwo'); 
        $changeOfGaugeTwo = $request->input('changeOfGaugeTwo'); 
        $flightNotesDeiCodeFour = $request->input('flightNotesDeiCodeFour'); 
        $flightNotesExplanationFour = $request->input('flightNotesExplanationFour'); 
        $flightNotesNoteFour = $request->input('flightNotesNoteFour');
        $flightNotesDeiCodeFive = $request->input('flightNotesDeiCodeFive'); 
        $flightNotesExplanationFive = $request->input('flightNotesExplanationFive'); 
        $flightNotesNoteFive = $request->input('flightNotesNoteFive'); 
        $flightNotesDeiCodeSix = $request->input('flightNotesDeiCodeSix'); 
        $flightNotesExplanationSix = $request->input('flightNotesExplanationSix'); 
        $flightNotesNoteSix = $request->input('flightNotesNoteSix');
        $flownMileageQtyTwo = $request->input('flownMileageQtyTwo'); 
        $iatciFlightTwo = $request->input('iatciFlightTwo'); 
        $journeyDurationTwo = $request->input('journeyDurationTwo'); 
        $onTimeRateTwo = $request->input('onTimeRateTwo'); 
        $remarkTwo = $request->input('remarkTwo'); 
        $secureFlightDataRequiredTwo = $request->input('secureFlightDataRequiredTwo'); 
        $stopQuantityTwo = $request->input('stopQuantityTwo'); 
        $ticketTypeTwo = $request->input('ticketTypeTwo');
        $journeyStartLocationCode = $request->input('journeyStartLocationCode');
        $passengerTypeCode = $request->input('passengerTypeCode'); 
        $quantity = $request->input('quantity'); 
        $tripType = $request->input('tripType');

        $xml = $this->getAirExtraChargesAndProductBuilder->getAirExtraChargesAndProductsRT(
            $bookingClassCabinOne, 
            $bookingClassResBookDesigCodeOne, 
            $bookingClassResBookDesigQuantityOne, 
            $bookingClassResBookDesigStatusCodeOne,
            $fareInfoCabinOne, 
            $fareInfoCabinClassCodeOne, 
            $fareBaggageAllowanceTypeOne, 
            $fareBaggageMaxAllowedPiecesOne, 
            $unitOfMeasureCodeOne, 
            $weightOne,
            $fareGroupNameOne, 
            $fareReferenceCodeOne, 
            $fareReferenceIDOne, 
            $fareReferenceNameOne, 
            $flightSegmentSequenceOne,
            $portTaxOne, 
            $fareInfoResBookDesigCodeOne,
            $airlineCodeOne, 
            $companyFullNameOne, 
            $arrivalAirportCityLocationCodeOne, 
            $arrivalAirportCityLocationNameOne, 
            $arrivalAirportCityLocationNameLanguageOne, 
            $arrivalAirportCountryLocationCodeOne,
            $arrivalAirportCountryLocationNameOne, 
            $arrivalAirportCountryLocationNameLangaugeOne, 
            $arrivalAirportCountryCurrencyCodeOne, 
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
            $departureCountryLocationNameOne, 
            $departureCountryLocationNameLanguageOne,
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
            $airEquipTypeOne, 
            $changeOfGaugeOne, 
            $flightNotesDeiCodeOne, 
            $flightNoteExplanationOne, 
            $flightNotesNoteOne,
            $flightNotesDeiCodeTwo, 
            $flightExplanationTwo, 
            $flightNotesNoteTwo, 
            $flightNoteDeiCodeThree, 
            $flightNotesExplanationThree, 
            $flightNotesNoteThree,
            $flownMileageQtyOne, 
            $iatciFlightOne, 
            $journeyDurationOne, 
            $onTimeRateOne, 
            $remarkOne, 
            $secureFlightDataRequiredOne, 
            $stopQuantityOne, 
            $ticketTypeOne,
            $bookingClassCabinTwo,
            $bookingClassResBookDesigCodeTwo,
            $bookingClassResBookDesigQuantityTwo, 
            $bookingClassResBookDesigStatusCodeTwo,
            $fareInfoCabinTwo, 
            $fareInfoCabinClassCodeTwo, 
            $fareBaggageAllowedTypeTwo, 
            $fareBaggageMaxAllowedPiecesTwo, 
            $unitOfMeasureCodeTwo, 
            $weightTwo,
            $fareGroupNameTwo, 
            $fareReferenceCodeTwo, 
            $fareReferenceIDTwo, 
            $fareReferenceNameTwo, 
            $flightSegmentSequenceTwo,
            $portTaxTwo, 
            $fareInfoResBookDesigCodeTwo,
            $airlineCodeTwo, 
            $companyFullNameTwo, 
            $arrivalAirportCityLocationCodeTwo, 
            $arrivalAirportCityLocationNameTwo, 
            $arrivalAirportCityLocationNameLanguageTwo, 
            $arrivalAirportCountryLocationCodeTwo,
            $arrivalAirportCountryLocatoinNameTwo, 
            $arrivalAirportCountryLocationNameLangaugeTwo, 
            $arrivalAirportCountryCurrencyCodeTwo, 
            $arrivalAirportCodeContextTwo, 
            $arrivalAirportLanguageTwo,
            $arrivalAirportLocationCodeTwo, 
            $arrivalAirportLocationNameTwo, 
            $arrivalAirportTimeZoneInfoTwo, 
            $arrivalDateTimeTwo, 
            $arrivalDateTimeUTCTwo,
            $departureAirportCityLocationCodeTwo, 
            $departureAirportCityLocationNameTwo, 
            $departureAirportCityLocationNameLanguageTwo, 
            $departureAirportCountryLocationCodeTwo, 
            $departureCountryLocationNameTwo, 
            $departureCountryLocationNameLanguageTwo,
            $departureAirportCountryCurrencyCodeTwo, 
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
            $codeShareTwo, 
            $distanceTwo, 
            $airEquipTypeTwo, 
            $changeOfGaugeTwo, 
            $flightNotesDeiCodeFour, 
            $flightNotesExplanationFour, 
            $flightNotesNoteFour,
            $flightNotesDeiCodeFive, 
            $flightNotesExplanationFive, 
            $flightNotesNoteFive, 
            $flightNotesDeiCodeSix, 
            $flightNotesExplanationSix, 
            $flightNotesNoteSix,
            $flownMileageQtyTwo, 
            $iatciFlightTwo, 
            $journeyDurationTwo, 
            $onTimeRateTwo, 
            $remarkTwo, 
            $secureFlightDataRequiredTwo, 
            $stopQuantityTwo, 
            $ticketTypeTwo,
            $journeyStartLocationCode,
            $passengerTypeCode, 
            $quantity, 
            $tripType
        );
    
        dd($xml);
    }

   

    public function getAirExtraChargesAndProductMD(GetExtraChargesAndProductMDRequest $request) {
        $bookingClassCabinOne = $request->input('bookingClassCabinOne');
        $bookingClassResBookDesigCodeOne = $request->input('bookingClassResBookDesigCodeOne');
        $bookingClassResBookDesigQuantityOne = $request->input('bookingClassResBookDesigQuantityOne'); 
        $bookingClassResBookDesigStatusCodeOne = $request->input('bookingClassResBookDesigStatusCodeOne');
        $fareInfoCabinOne = $request->input('fareInfoCabinOne'); 
        $fareInfoCabonClassCodeOne = $request->input('fareInfoCabonClassCodeOne');
        $fareBaggageAllowanceTypeOne = $request->input('fareBaggageAllowanceTypeOne'); 
        $fareBaggageAllowanceMaxAllowedPiecesOne = $request->input('fareBaggageAllowanceMaxAllowedPiecesOne');
        $unitOfMeasureCodeOne = $request->input('unitOfMeasureCodeOne'); 
        $weightOne = $request->input('weightOne'); 
        $fareGroupNameOne = $request->input('fareGroupNameOne'); 
        $fareReferenceCodeOne = $request->input('fareReferenceCodeOne'); 
        $fareReferenceIDOne = $request->input('fareReferenceIDOne'); 
        $fareReferenceNameOne = $request->input('fareReferenceNameOne');
        $flightSegmentSequenceOne = $request->input('flightSegmentSequenceOne'); 
        $portTaxOne = $request->input('portTaxOne'); 
        $resBookDesigCodeOne = $request->input(''); 
        $airlineCodeOne = $request->input('airlineCodeOne'); 
        $companyFullNameOne = $request->input('companyFullNameOne'); 
        $arrivalAirportCityLocationCodeOne = $request->input('arrivalAirportCityLocationCodeOne');
        $arrivalAirportCityLocationNameOne = $request->input('arrivalAirportCityLocationNameOne'); 
        $arrivalAirportCityLocationNameLanguageOne = $request->input('arrivalAirportCityLocationNameLanguageOne'); 
        $arrivalAirportCountryLocationCodeOne = $request->input('arrivalAirportCountryLocationCodeOne');
        $arrivalAirportCountryLocationNameOne = $request->input('arrivalAirportCountryLocationNameOne'); 
        $arrivalAirportCountryLocationNameLanguageOne = $request->input('arrivalAirportCountryLocationNameLanguageOne'); 
        $arrivalAirportCountryCurrencyCodeOne = $request->input('arrivalAirportCountryCurrencyCodeOne');
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
        $equipmentAirEquipTypeOne = $request->input('equipmentAirEquipTypeOne'); 
        $equipmentChangeOfGaugeOne = $request->input('equipmentChangeOfGaugeOne'); 
        $flightNotesDeiCodeOne = $request->input('flightNotesDeiCodeOne'); 
        $flightNotesExplanationOne = $request->input('flightNotesExplanationOne');
        $flightNotesNoteOne = $request->input('flightNotesNoteOne'); 
        $flightNotesDeiCodeTwo = $request->input('flightNotesDeiCodeTwo'); 
        $flightNotesExplanationTwo = $request->input('flightNotesExplanationTwo'); 
        $flightNotesNoteTwo = $request->input('flightNotesNoteTwo');
        $flightNotesDeiCodeThree = $request->input('flightNotesDeiCodeThree'); 
        $flightNotesExplanationThree = $request->input('flightNotesExplanationThree'); 
        $flightNotesNoteThree = $request->input('flightNotesNoteThree'); 
        $flownMileageQtyOne = $request->input('flownMileageQtyOne'); 
        $iatciFlightOne = $request->input('iatciFlightOne');
        $journeyDurationOne = $request->input('journeyDurationOne'); 
        $onTimeRateOne = $request->input('onTimeRateOne'); 
        $remarkOne = $request->input('remarkOne'); 
        $secureFlightDataRequiredOne = $request->input('secureFlightDataRequiredOne'); 
        $stopQuantityOne = $request->input('stopQuantityOne'); 
        $ticketTypeOne = $request->input('ticketTypeOne');          
        $bookingClassCabinTwo = $request->input('bookingClassCabinTwo');
        $bookingClassResBookDesigCodeTwo = $request->input('bookingClassResBookDesigCodeTwo');
        $bookingClassResBookDesigQuantityTwo = $request->input('bookingClassResBookDesigQuantityTwo'); 
        $bookingClassResBookDesigStatusCodeTwo = $request->input('bookingClassResBookDesigStatusCodeTwo');
        $fareInfoCabinTwo = $request->input('fareInfoCabinTwo'); 
        $fareInfoCabonClassCodeTwo = $request->input('fareInfoCabonClassCodeTwo');
        $fareBaggageAllowanceTypeTwo = $request->input('fareBaggageAllowanceTypeTwo'); 
        $fareBaggageAllowanceMaxAllowedPiecesTwo = $request->input('fareBaggageAllowanceMaxAllowedPiecesTwo');
        $unitOfMeasureCodeTwo = $request->input('unitOfMeasureCodeTwo'); 
        $weightTwo = $request->input('weightTwo'); 
        $fareGroupNameTwo = $request->input('fareGroupNameTwo'); 
        $fareReferenceCodeTwo = $request->input('fareReferenceCodeTwo'); 
        $fareReferenceIDTwo = $request->input('fareReferenceIDTwo'); 
        $fareReferenceNameTwo = $request->input('fareReferenceNameTwo');
        $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo'); 
        $portTaxTwo = $request->input('portTaxTwo'); 
        $resBookDesigCodeTwo = $request->input('resBookDesigCodeTwo');
        $airlineCodeTwo = $request->input('airlineCodeTwo'); 
        $companyFullNameTwo = $request->input('companyFullNameTwo'); 
        $arrivalAirportCityLocationCodeTwo = $request->input('arrivalAirportCityLocationCodeTwo');
        $arrivalAirportCityLocationNameTwo = $request->input('arrivalAirportCityLocationNameTwo'); 
        $arrivalAirportCityLocationNameLanguageTwo = $request->input('arrivalAirportCityLocationNameLanguageTwo'); 
        $arrivalAirportCountryLocationCodeTwo = $request->input('arrivalAirportCountryLocationCodeTwo');
        $arrivalAirportCountryLocationNameTwo = $request->input('arrivalAirportCountryLocationNameTwo'); 
        $arrivalAirportCountryLocationNameLanguageTwo = $request->input('arrivalAirportCountryLocationNameLanguageTwo'); 
        $arrivalAirportCountryCurrencyCodeTwo = $request->input('arrivalAirportCountryCurrencyCodeTwo');
        $arrivalAirportCodeContextTwo = $request->input('arrivalAirportCodeContextTwo'); 
        $arrivalAirportLanguageTwo = $request->input('arrivalAirportLanguageTwo'); 
        $arrivalAirportLocationCodeTwo = $request->input('arrivalAirportLocationCodeTwo'); 
        $arrivalAirportLocationNameTwo = $request->input('arrivalAirportLocationNameTwo'); 
        $arrivalAirportTimeZoneInfoTwo = $request->input('arrivalAirportTimeZoneInfoTwo');
        $arrivalDateTimeTwo = $request->input('arrivalDateTimeTwo'); 
        $arrivalDateTimeUTCTwo = $request->input('arrivalDateTimeUTCTwo'); 
        $departureAirportCityLocationCodeTwo = $request->input('departureAirportCityLocationCodeTwo'); 
        $departureAirportCityLocationNameTwo = $request->input('departureAirportCityLocationNameTwo');
        $departureAirportCityLocationNameLanguageTwo = $request->input('departureAirportCityLocationNameLanguageTwo'); 
        $departureAirportCountryLocationCodeTwo = $request->input('departureAirportCountryLocationCodeTwo'); 
        $departureAirportCountryLocationNameTwo = $request->input('departureAirportCountryLocationNameTwo');
        $departureAirportCountryLocationNameLanguageTwo = $request->input('departureAirportCountryLocationNameLanguageTwo'); 
        $departureAirportCountryCurrencyCodeTwo = $request->input('departureAirportCountryCurrencyCodeTwo'); 
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
        $codeShareTwo = $request->input('codeShareTwo');
        $distanceTwo = $request->input('distanceTwo'); 
        $equipmentAirEquipTypeTwo = $request->input('equipmentAirEquipTypeTwo'); 
        $equipmentChangeOfGaugeTwo = $request->input('equipmentChangeOfGaugeTwo'); 
        $flightNotesDeiCodeFour = $request->input('flightNotesDeiCodeFour'); 
        $flightNotesExplanationFour = $request->input('flightNotesExplanationFour');
        $flightNotesNoteFour = $request->input('flightNotesNoteFour'); 
        $flightNotesDeiCodeFive = $request->input('flightNotesDeiCodeFive'); 
        $flightNotesExplanationFive = $request->input('flightNotesExplanationFive'); 
        $flightNotesNoteFive = $request->input('flightNotesNoteFive');
        $flightNotesDeiCodeSix = $request->input('flightNotesDeiCodeSix'); 
        $flightNotesExplanationSix = $request->input('flightNotesExplanationSix'); 
        $flightNotesNoteSix = $request->input('flightNotesNoteSix'); 
        $flownMileageQtyTwo = $request->input('flownMileageQtyTwo'); 
        $iatciFlightTwo = $request->input('iatciFlightTwo');
        $journeyDurationTwo = $request->input('journeyDurationTwo'); 
        $onTimeRateTwo = $request->input('onTimeRateTwo'); 
        $remarkTwo = $request->input('remarkTwo'); 
        $secureFlightDataRequiredTwo = $request->input('secureFlightDataRequiredTwo'); 
        $stopQuantityTwo = $request->input('stopQuantityTwo'); 
        $ticketTypeTwo = $request->input('ticketTypeTwo');
        $locationCode = $request->input('locationCode');
        $passengerTypeCode = $request->input('passengerTypeCode');
        $passengerTypeQuantity = $request->input('passengerTypeQuantity');
        $tripType = $request->input('tripType');
        

        $xml = $this->getAirExtraChargesAndProductBuilder->getAirExtraChargesAndProductMD(
            $bookingClassCabinOne,
            $bookingClassResBookDesigCodeOne,
            $bookingClassResBookDesigQuantityOne, 
            $bookingClassResBookDesigStatusCodeOne,
            $fareInfoCabinOne, 
            $fareInfoCabonClassCodeOne,
            $fareBaggageAllowanceTypeOne, 
            $fareBaggageAllowanceMaxAllowedPiecesOne,
            $unitOfMeasureCodeOne, 
            $weightOne, 
            $fareGroupNameOne, 
            $fareReferenceCodeOne, 
            $fareReferenceIDOne, 
            $fareReferenceNameOne,
            $flightSegmentSequenceOne, 
            $portTaxOne, 
            $resBookDesigCodeOne, 
            $airlineCodeOne, 
            $companyFullNameOne, 
            $arrivalAirportCityLocationCodeOne,
            $arrivalAirportCityLocationNameOne, 
            $arrivalAirportCityLocationNameLanguageOne, 
            $arrivalAirportCountryLocationCodeOne,
            $arrivalAirportCountryLocationNameOne, 
            $arrivalAirportCountryLocationNameLanguageOne, 
            $arrivalAirportCountryCurrencyCodeOne,
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
            $equipmentAirEquipTypeOne, 
            $equipmentChangeOfGaugeOne, 
            $flightNotesDeiCodeOne, 
            $flightNotesExplanationOne,
            $flightNotesNoteOne, 
            $flightNotesDeiCodeTwo, 
            $flightNotesExplanationTwo, 
            $flightNotesNoteTwo,
            $flightNotesDeiCodeThree, 
            $flightNotesExplanationThree, 
            $flightNotesNoteThree, 
            $flownMileageQtyOne, 
            $iatciFlightOne,
            $journeyDurationOne, 
            $onTimeRateOne, 
            $remarkOne, 
            $secureFlightDataRequiredOne, 
            $stopQuantityOne, 
            $ticketTypeOne,          
            $bookingClassCabinTwo,
            $bookingClassResBookDesigCodeTwo,
            $bookingClassResBookDesigQuantityTwo, 
            $bookingClassResBookDesigStatusCodeTwo,
            $fareInfoCabinTwo, 
            $fareInfoCabonClassCodeTwo,
            $fareBaggageAllowanceTypeTwo, 
            $fareBaggageAllowanceMaxAllowedPiecesTwo,
            $unitOfMeasureCodeTwo, 
            $weightTwo, 
            $fareGroupNameTwo, 
            $fareReferenceCodeTwo, 
            $fareReferenceIDTwo, 
            $fareReferenceNameTwo,
            $flightSegmentSequenceTwo, 
            $portTaxTwo, 
            $resBookDesigCodeTwo,
            $airlineCodeTwo, 
            $companyFullNameTwo, 
            $arrivalAirportCityLocationCodeTwo,
            $arrivalAirportCityLocationNameTwo, 
            $arrivalAirportCityLocationNameLanguageTwo, 
            $arrivalAirportCountryLocationCodeTwo,
            $arrivalAirportCountryLocationNameTwo, 
            $arrivalAirportCountryLocationNameLanguageTwo, 
            $arrivalAirportCountryCurrencyCodeTwo,
            $arrivalAirportCodeContextTwo, 
            $arrivalAirportLanguageTwo, 
            $arrivalAirportLocationCodeTwo, 
            $arrivalAirportLocationNameTwo, 
            $arrivalAirportTimeZoneInfoTwo,
            $arrivalDateTimeTwo, 
            $arrivalDateTimeUTCTwo, 
            $departureAirportCityLocationCodeTwo, 
            $departureAirportCityLocationNameTwo,
            $departureAirportCityLocationNameLanguageTwo, 
            $departureAirportCountryLocationCodeTwo, 
            $departureAirportCountryLocationNameTwo,
            $departureAirportCountryLocationNameLanguageTwo, 
            $departureAirportCountryCurrencyCodeTwo, 
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
            $codeShareTwo,
            $distanceTwo, 
            $equipmentAirEquipTypeTwo, 
            $equipmentChangeOfGaugeTwo, 
            $flightNotesDeiCodeFour, 
            $flightNotesExplanationFour,
            $flightNotesNoteFour, 
            $flightNotesDeiCodeFive, 
            $flightNotesExplanationFive, 
            $flightNotesNoteFive,
            $flightNotesDeiCodeSix, 
            $flightNotesExplanationSix, 
            $flightNotesNoteSix, 
            $flownMileageQtyTwo, 
            $iatciFlightTwo,
            $journeyDurationTwo, 
            $onTimeRateTwo, 
            $remarkTwo, 
            $secureFlightDataRequiredTwo, 
            $stopQuantityTwo, 
            $ticketTypeTwo,
            $locationCode,
            $passengerTypeCode,
            $passengerTypeQuantity,
            $tripType
        );

        dd($xml);
    
    }

    public function getAirExtraChargesAndProductTwoA(GetExtraChargesAndProductTwoARequest $request) {
        $bookingClassCabin = $request->input('bookingClassCabin'); 
        $bookingClassResBookDesigCode = $request->input('bookingClassResBookDesigCode'); 
        $bookingClassResBookDesigQuantity = $request->input('bookingClassResBookDesigQuantity'); 
        $bookingClassResBookDesigStatusCode = $request->input('bookingClassResBookDesigStatusCode');
        $fareInfoCabin = $request->input('fareInfoCabin'); 
        $fareInfoCabinClassCode = $request->input('fareInfoCabinClassCode'); 
        $fareBaggageAllowanceType = $request->input('fareBaggageAllowanceType'); 
        $fareBaggageMaxAllowedPieces = $request->input('fareBaggageMaxAllowedPieces');
        $unitOfMeasureCode = $request->input('unitOfMeasureCode'); 
        $weight = $request->input('weight');
        $fareGroupName = $request->input('fareGroupName'); 
        $fareReferenceCode = $request->input('fareReferenceCode'); 
        $fareReferenceID = $request->input('fareReferenceID'); 
        $fareReferenceName = $request->input('fareReferenceName'); 
        $flightSegmentSequence = $request->input('flightSegmentSequence');
        $portTax = $request->input('portTax'); 
        $resBookDesigCode = $request->input('resBookDesigCode');
        $airlineCode = $request->input('airlineCode'); 
        $companyFullName = $request->input('companyFullName'); 
        $arrivalAirportCityLocationCode = $request->input('arrivalAirportCityLocationCode'); 
        $arrivalAirportCityLocationName = $request->input('arrivalAirportCityLocationName'); 
        $arrivalAirportCityLocationNameLanguage = $request->input('arrivalAirportCityLocationNameLanguage');
        $arrivalAirportCountryLocationCode = $request->input('arrivalAirportCountryLocationCode'); 
        $arrivalAirportCountryLocationName = $request->input('arrivalAirportCountryLocationName'); 
        $arrivalAirportCountryLocationNameLangauge = $request->input('arrivalAirportCountryLocationNameLangauge'); 
        $arrivalAirportCountryCurrencyCode = $request->input('arrivalAirportCountryCurrencyCode');
        $arrivalAirportCodeContext = $request->input('arrivalAirportCodeContext'); 
        $arrivalAirportLanguage = $request->input('arrivalAirportLanguage'); 
        $arrivalAirportLocationCode = $request->input('arrivalAirportLocationCode'); 
        $arrivalAirportLocationName = $request->input('arrivalAirportLocationName'); 
        $arrivalAirportTimeZoneInfo = $request->input('arrivalAirportTimeZoneInfo');
        $arrivalDateTime = $request->input('arrivalDateTime'); 
        $arrivalDateTimeUTC = $request->input('arrivalDateTimeUTC'); 
        $departureAirportCitytLocationCode = $request->input('departureAirportCitytLocationCode'); 
        $departureAirportCityLocationName = $request->input('departureAirportCityLocationName'); 
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountrytLocationCode = $request->input('departureAirportCountrytLocationCode'); 
        $departureAirportCountryLocationName = $request->input('departureAirportCountryLocationName'); 
        $departureAirportCountryLocationNameLanguage = $request->input('departureAirportCountryLocationNameLanguage'); 
        $departureAirportCountyCurrencyCode = $request->input('departureAirportCountyCurrencyCode');
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
        $airEquipType = $request->input('airEquipType'); 
        $changeOfGuage = $request->input('changeOfGuage'); 
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
        $locationCode = $request->input('locationCode'); 
        $passengerTypeCode = $request->input('passengerTypeCode'); 
        $quantity = $request->input('quantity'); 
        $passengerTypeCodeTwo = $request->input('passengerTypeCodeTwo'); 
        $quantityTwo = $request->input('quantityTwo'); 
        $passengerTypeCodeThree = $request->input('passengerTypeCodeThree'); 
        $quantityThree = $request->input('quantityThree'); 
        $tripType = $request->input('tripType');

        $xml = $this->getAirExtraChargesAndProductBuilder->getExtraChargesAndProductTwoA(
            $bookingClassCabin, 
            $bookingClassResBookDesigCode, 
            $bookingClassResBookDesigQuantity, 
            $bookingClassResBookDesigStatusCode,
            $fareInfoCabin, 
            $fareInfoCabinClassCode, 
            $fareBaggageAllowanceType, 
            $fareBaggageMaxAllowedPieces,
            $unitOfMeasureCode, 
            $weight,
            $fareGroupName, 
            $fareReferenceCode, 
            $fareReferenceID, 
            $fareReferenceName, 
            $flightSegmentSequence,
            $portTax, 
            $resBookDesigCode,
            $airlineCode, 
            $companyFullName, 
            $arrivalAirportCityLocationCode, 
            $arrivalAirportCityLocationName, 
            $arrivalAirportCityLocationNameLanguage,
            $arrivalAirportCountryLocationCode, 
            $arrivalAirportCountryLocationName, 
            $arrivalAirportCountryLocationNameLangauge, 
            $arrivalAirportCountryCurrencyCode,
            $arrivalAirportCodeContext, 
            $arrivalAirportLanguage, 
            $arrivalAirportLocationCode, 
            $arrivalAirportLocationName, 
            $arrivalAirportTimeZoneInfo,
            $arrivalDateTime, 
            $arrivalDateTimeUTC, 
            $departureAirportCitytLocationCode, 
            $departureAirportCityLocationName, 
            $departureAirportCityLocationNameLanguage,
            $departureAirportCountrytLocationCode, 
            $departureAirportCountryLocationName, 
            $departureAirportCountryLocationNameLanguage, 
            $departureAirportCountyCurrencyCode,
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
            $airEquipType, 
            $changeOfGuage, 
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
            $locationCode, 
            $passengerTypeCode, 
            $quantity, 
            $passengerTypeCodeTwo, 
            $quantityTwo, 
            $passengerTypeCodeThree, 
            $quantityThree, 
            $tripType
        );

        dd($xml);
    }


    public function getAirExtraChargesAndProductOw(GetExtraChargesAndProductOWRequest $request) {
        $bookingClassCabin = $request->input('bookingClassCabin');
        $bookingClassResBookDesigCode = $request->input('bookingClassResBookDesigCode');
        $bookingClassResBookDesigQuantity = $request->input('bookingClassResBookDesigQuantity');
        $bookingClassResBookDesigStatusCode = $request->input('bookingClassResBookDesigStatusCode');
        $fareInfoCabin = $request->input('fareInfoCabin');
        $fareInfoCabinClassCode = $request->input('fareInfoCabinClassCode');
        $fareBaggageAllowanceType = $request->input('fareBaggageAllowanceType');
        $fareBaggageAllowanceMaxAllowedPieces = $request->input('fareBaggageAllowanceMaxAllowedPieces');
        $unitOfMeasureCode = $request->input('unitOfMeasureCode');
        $weight = $request->input('weight');
        $fareGroupName = $request->input('fareGroupName');
        $fareReferenceCode = $request->input('fareReferenceCode');
        $fareReferenceID = $request->input('fareReferenceID');
        $fareReferenceName = $request->input('fareReferenceName');
        $flightSegmentSequence = $request->input('flightSegmentSequence');
        $portTax = $request->input('portTax');
        $resBookDesigCode = $request->input('resBookDesigCode');
        $airlineCode = $request->input('airlineCode');
        $companyFullName = $request->input('companyFullName');
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
        $arrivalDateTime = $request->input('arrivalDateTime');
        $arrivalDateTimeUTC = $request->input('arrivalDateTimeUTC');
        $departureAirportCityLocationCode = $request->input('departureAirportCityLocationCode');
        $departureAirportCityLocationName = $request->input('departureAirportCityLocationName');
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountryLocationCode = $request->input('departureAirportCountryLocationCode');
        $departureAirportCountryLocationName = $request->input('departureAirportCountryLocationName');
        $departureAirportCountryNameLanguage = $request->input('departureAirportCountryNameLanguage');
        $departureAirportCountryCurrencyCode = $request->input('departureAirportCountryCurrencyCode');
        $departureAirportCodeContext = $request->input('departureAirportCodeContext');
        $departureAirportLanguage = $request->input('departureAirportLanguage');
        $departureAirportLocationCode = $request->input('departureAirportLocationCode');
        $departureAirportLocationName = $request->input('departureAirportLocationName');
        $departureAiportTimeZoneInfo = $request->input('departureAiportTimeZoneInfo');
        $departureDateTime = $request->input('departureDateTime');
        $departureDateTimeUTC = $request->input('departureDateTimeUTC');
        $flightNumber = $request->input('flightNumber');
        $flightSegmentID = $request->input('flightSegmentID');
        $ondControlled = $request->input('ondControlled');
        $sector = $request->input('sector');
        $codeShare = $request->input('codeShare');
        $distance = $request->input('distance');
        $airEquipType = $request->input('airEquipType');
        $changeOfGuage = $request->input('changeOfGuage');
        $flightNotesDeiCodeOne = $request->input('flightNotesDeiCodeOne');
        $flightExplanationOne = $request->input('flightExplanationOne');
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
        $locationCode = $request->input('locationCode');
        $passengerTypeCode = $request->input('passengerTypeCode'); 
        $quantity = $request->input('quantity');
        $tripType = $request->input('tripType');

        $xml = $this->getAirExtraChargesAndProductBuilder->getExtraChargesAndProductOW(
            $bookingClassCabin,
            $bookingClassResBookDesigCode,
            $bookingClassResBookDesigQuantity,
            $bookingClassResBookDesigStatusCode,
            $fareInfoCabin,
            $fareInfoCabinClassCode,
            $fareBaggageAllowanceType,
            $fareBaggageAllowanceMaxAllowedPieces,
            $unitOfMeasureCode,
            $weight,
            $fareGroupName,
            $fareReferenceCode,
            $fareReferenceID,
            $fareReferenceName,
            $flightSegmentSequence,
            $portTax,
            $resBookDesigCode,
            $airlineCode,
            $companyFullName,
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
            $arrivalDateTime,
            $arrivalDateTimeUTC,
            $departureAirportCityLocationCode,
            $departureAirportCityLocationName,
            $departureAirportCityLocationNameLanguage,
            $departureAirportCountryLocationCode,
            $departureAirportCountryLocationName,
            $departureAirportCountryNameLanguage,
            $departureAirportCountryCurrencyCode,
            $departureAirportCodeContext,
            $departureAirportLanguage,
            $departureAirportLocationCode,
            $departureAirportLocationName,
            $departureAiportTimeZoneInfo,
            $departureDateTime,
            $departureDateTimeUTC,
            $flightNumber,
            $flightSegmentID,
            $ondControlled,
            $sector,
            $codeShare,
            $distance,
            $airEquipType,
            $changeOfGuage,
            $flightNotesDeiCodeOne,
            $flightExplanationOne,
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
            $locationCode,
            $passengerTypeCode, 
            $quantity,
            $tripType
        );

        dd($xml);
    }
    

}
