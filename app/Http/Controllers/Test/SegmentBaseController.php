<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\SegmentBase\SegmentBaseAvailableSpecialServicesRequest;
use App\Services\Soap\SegmentBaseRequestBuilder;
use Illuminate\Http\Request;

class SegmentBaseController extends Controller
{
    protected $segmentBaseRequestBuilder;
    protected $craneAncillaryOTASoapService;

    public function __construct(SegmentBaseRequestBuilder $segmentBaseRequestBuilder)
    {
        $this->segmentBaseRequestBuilder = $segmentBaseRequestBuilder;
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }

    public function segmentBaseAvailableSpecialServices(SegmentBaseAvailableSpecialServicesRequest $request) {
        $bookingClassCabin = $request->input('bookingClassCabin');
        $bookingResBookDesigCode = $request->input('bookingResBookDesigCode');
        $bookingClassResBookDesigQuantity = $request->input('bookingClassResBookDesigQuantity');
        $bookingClassResBookDesigStatusCode = $request->input('bookingClassResBookDesigStatusCode');
        $fareInfoCabin = $request->input('fareInfoCabin');
        $fareInfoCabinClassCode = $request->input('fareInfoCabinClassCode');
        $fareBaggageAllowanceType = $request->input('fareBaggageAllowanceType');
        $fareBaggageMaxAllowedPieces = $request->input('fareBaggageAllowanceType');
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
        $airlineCompanyFullName = $request->input('airlineCompanyFullName');
        $arrivalCityLocationCode = $request->input('arrivalCityLocationCode');
        $arrivalCityLocationName = $request->input('arrivalCityLocationName');
        $arrivalCityLocationNameLanguage = $request->input('arrivalCityLocationNameLanguage');
        $arrivalCountryLocationCode = $request->input('arrivalCountryLocationCode');
        $arrivalCountryLocationName = $request->input('arrivalCountryLocationName');
        $arrivalCountryLocationNameLanguage = $request->input('arrivalCountryLocationNameLanguage');
        $arrivalCountryCurrencyCode = $request->input('arrivalCountryCurrencyCode');
        $arrivalCodeContext = $request->input('arrivalCodeContext');
        $arrivalLanguage = $request->input('arrivalLanguage');
        $arrivalLocationCode = $request->input('arrivalLocationCode');
        $arrivalLocationName = $request->input('arrivalLocationName');
        $arrivalTimeZoneInfo = $request->input('arrivalTimeZoneInfo');
        $arrivalDateTime = $request->input('arrivalDateTime');
        $arrivalDateTimeUTC = $request->input('arrivalDateTimeUTC');
        $departureCityLocationCode = $request->input('departureCityLocationCode');
        $departureCityLocationName = $request->input('departureCityLocationName');
        $departureCityLocationNameLanguage = $request->input('departureCityLocationNameLanguage');
        $departureCountryLocationCode = $request->input('departureCountryLocationCode');
        $departureCountryLocationName = $request->input('departureCountryLocationName'); 
        $departureCountryLocationNameLanguage = $request->input('departureCountryLocationNameLanguage');
        $departureCountryCurrencyCode = $request->input('departureCountryCurrencyCode');
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
        $changeOfGauge = $request->input('changeOfGauge');
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
        $secureFlightDataRequired = $request->input('remark');
        $stopQuantity = $request->input('stopQuantity');
        $ticketType = $request->input('ticketType');


        $xml = $this->segmentBaseRequestBuilder->segmentBaseAvailableSpecialServices(
            $bookingClassCabin,
            $bookingResBookDesigCode,
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
            $airlineCompanyFullName,
            $arrivalCityLocationCode,
            $arrivalCityLocationName,
            $arrivalCityLocationNameLanguage,
            $arrivalCountryLocationCode,
            $arrivalCountryLocationName,
            $arrivalCountryLocationNameLanguage,
            $arrivalCountryCurrencyCode,
            $arrivalCodeContext,
            $arrivalLanguage,
            $arrivalLocationCode,
            $arrivalLocationName,
            $arrivalTimeZoneInfo,
            $arrivalDateTime,
            $arrivalDateTimeUTC,
            $departureCityLocationCode,
            $departureCityLocationName,
            $departureCityLocationNameLanguage,
            $departureCountryLocationCode,
            $departureCountryLocationName,
            $departureCountryLocationNameLanguage,
            $departureCountryCurrencyCode,
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
            $changeOfGauge,
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
            $ticketType
        );
         

        try {
            $function = 'http://impl.soap.ws.crane.hititcs.com/SegmentBaseAvailableSpecialServices';

            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            dd($response);
            
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
