<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\seatMapRequest;
use App\Services\Soap\SeatMapBuilder;
use Illuminate\Http\Request;

class SeatMapController extends Controller
{   
    protected $seatMapBuilder;
    protected $craneAncillaryOTASoapService;

    public function __construct(SeatMapBuilder $seatMapBuilder)
    {
        $this->seatMapBuilder = $seatMapBuilder; 
        $this->craneAncillaryOTASoapService = app("CraneAncillaryOTASoapService");
    }

    public function seatMap(seatMapRequest $request) {
        $airlineCode = $request->input('airlineCode'); 
        $airlineCodeContext = $request->input('airlineCodeContext');
        $arrivalAirportCityLocationCode = $request->input('arrivalAirportCityLocationCode');
        $arrivalAirportCityLocationName = $request->input('arrivalAirportCityLocationName'); 
        $arrivalAirportCitylocationNameLanguage = $request->input('arrivalAirportCitylocationNameLanguage');
        $arrivalAirportCountryLocationCode = $request->input('arrivalAirportCountryLocationCode'); 
        $arrivalAirportCountryLocationName = $request->input('arrivalAirportCountryLocationName'); 
        $arrivalAirportCountryLocationNameLanguage = $request->input('arrivalAirportCountryLocationNameLanguage'); 
        $arrivalAirportCountryCurrencyCode = $request->input('arrivalAirportCountryCurrencyCode');
        $arrivalAirportCodeContext = $request->input('arrivalAirportCodeContext'); 
        $arrivalAirportLanguage = $request->input('arrivalAirportLanguage'); 
        $arrivalAirportLocationCode = $request->input('arrivalAirportLocationCode'); 
        $arrivalAirportLocationName = $request->input('arrivalAirportLocationName'); 
        $arrivalAirportTerminal = $request->input('arrivalAirportTerminal'); 
        $arrivalAirportTimeZoneInfo = $request->input('arrivalAirportTimeZoneInfo');
        $arrivalAirportDateTime = $request->input('arrivalAirportDateTime'); 
        $arrivalAirportDateTimeUTC = $request->input('arrivalAirportDateTimeUTC');
        $departureAirportCityLocationCode = $request->input('departureAirportCityLocationCode'); 
        $departureAirportCityLocationName = $request->input('departureAirportCityLocationName'); 
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountryLocationCode = $request->input('departureAirportCountryLocationCode'); 
        $departureAirportCountryLocationName = $request->input('departureAirportCountryLocationName'); 
        $departureAirportLocationNameLanguage = $request->input('departureAirportLocationNameLanguage'); 
        $departureAirportCurrencyCode = $request->input('departureAirportCurrencyCode');
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
        $flightNotes = $request->input('flightNotes'); 
        $flownMileageQty = $request->input('flownMileageQty'); 
        $iatciFlight = $request->input('iatciFlight'); 
        $journeyDuration = $request->input('journeyDuration'); 
        $onTimeRate = $request->input('onTimeRate'); 
        $remark = $request->input('remark'); 
        $secureFlightDataRequired = $request->input('secureFlightDataRequired');
        $segmentStatusByFirstLeg = $request->input('segmentStatusByFirstLeg'); 
        $stopQuantity = $request->input('stopQuantity'); 
        $companyNameCitycode = $request->input('companyNameCitycode'); 
        $companyNameCode = $request->input('companyNameCode'); 
        $companyNameCodeContext = $request->input('companyNameCodeContext');
        $companyFullName = $request->input('companyFullName'); 
        $companyShortName = $request->input('companyShortName'); 
        $countryCode = $request->input('countryCode'); 
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID');

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetSeatMap';

        $xml = $this->seatMapBuilder->seatMap(
            $airlineCode, 
            $airlineCodeContext,
            $arrivalAirportCityLocationCode,
            $arrivalAirportCityLocationName, 
            $arrivalAirportCitylocationNameLanguage,
            $arrivalAirportCountryLocationCode, 
            $arrivalAirportCountryLocationName, 
            $arrivalAirportCountryLocationNameLanguage, 
            $arrivalAirportCountryCurrencyCode,
            $arrivalAirportCodeContext, 
            $arrivalAirportLanguage, 
            $arrivalAirportLocationCode, 
            $arrivalAirportLocationName, 
            $arrivalAirportTerminal, 
            $arrivalAirportTimeZoneInfo,
            $arrivalAirportDateTime, 
            $arrivalAirportDateTimeUTC,
            $departureAirportCityLocationCode, 
            $departureAirportCityLocationName, 
            $departureAirportCityLocationNameLanguage,
            $departureAirportCountryLocationCode, 
            $departureAirportCountryLocationName, 
            $departureAirportLocationNameLanguage, 
            $departureAirportCurrencyCode,
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
            $flightNotes,            
            $flownMileageQty, 
            $iatciFlight, 
            $journeyDuration, 
            $onTimeRate, 
            $remark, 
            $secureFlightDataRequired,
            $segmentStatusByFirstLeg, 
            $stopQuantity, 
            $companyNameCitycode, 
            $companyNameCode, 
            $companyNameCodeContext,
            $companyFullName, 
            $companyShortName, 
            $countryCode, 
            $ID, 
            $referenceID
        );

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);

           
            $airplaneCabinList = $response['AirSeatMapResponse']['seatMapResponse']['airplane']['airplaneCabinList'];

            $seatArray = [];
            foreach($airplaneCabinList as $airplaneCabin) {
                $airplaneRowList = $airplaneCabin['airplaneRowList'];
                foreach($airplaneRowList as $airplaneRow) {
                    $seats =  $airplaneRow['seats'];
                    
                    // Add each seat to the seatArray
                    foreach($seats as $seat) {
                        $seatArray[] = $seat;
                    }
                    
                    // $seatArray[] = $seats;
                }
            }
            return response()->json([
                "error" => false,
                "seatArray" => $seatArray
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        } 
    }    
}
