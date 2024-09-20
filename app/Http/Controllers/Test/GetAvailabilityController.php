<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\GetAvailability\GetAvailabilityMDRequest;
use App\Http\Requests\Test\GetAvailability\GetAvailabilityOWRequest;
use App\Http\Requests\Test\GetAvailability\GetAvailabilityRTRequest;
use App\Http\Requests\Test\GetAvailability\GetAvailabilityTwoARequest;
use App\Services\Soap\GetAvailabilityBuilder;
use Illuminate\Http\Request;

class GetAvailabilityController extends Controller
{
    //
    protected $getAvailabilityBuilder;
    protected $craneOTASoapService;

    public function __construct(GetAvailabilityBuilder $getAvailabilityBuilder)
    {
        $this->getAvailabilityBuilder = $getAvailabilityBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
    }

    public function getAvailabilityGeneralParameters() {
        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailabilityGeneralParameters';
        $xml = $this->getAvailabilityBuilder->getAvailabilityGeneralParameters();
        try {

            $response = $this->craneOTASoapService->run($function, $xml);
            dd($response);
           

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getAvailabilityRT(GetAvailabilityRTRequest $request) {
        $originDateOffsetOne = $request->input('originDateOffsetOne'); 
        $originDepartureDateTimeOne = $request->input('originDateOffsetOne'); 
        $originDestinationLocationCode = $request->input('originDateOffsetOne');
        $flexibleFaresOnlyOne = $request->input('originDateOffsetOne');
        $includeInterlineFlightsOne = $request->input('originDateOffsetOne'); 
        $openFlightOne = $request->input('originDateOffsetOne');
        $originLocationCodeOne = $request->input('originDateOffsetOne'); 
        $originDataOffsetTwo = $request->input('originDataOffsetTwo'); 
        $originDepartureDateTimeTwo = $request->input('originDataOffsetTwo');
        $destinationLocationCodeTwo = $request->input('destinationLocationCodeTwo'); 
        $flexibleFaresOnlyTwo = $request->input('flexibleFaresOnlyTwo'); 
        $includeInterlineFlightsTwo = $request->input('includeInterlineFlightsTwo');
        $openFlightTwo = $request->input('openFlightTwo'); 
        $originLocationCodeTwo = $request->input('originLocationCodeTwo'); 
        $travelerInformationCode = $request->input('travelerInformationCode'); 
        $travelerQuantity = $request->input('travelerQuantity');
        $tripType = $request->input('tripType');

        $xml = $this->getAvailabilityBuilder->getAvailabilityRT(
            $originDateOffsetOne, 
            $originDepartureDateTimeOne, 
            $originDestinationLocationCode,
            $flexibleFaresOnlyOne,
            $includeInterlineFlightsOne, 
            $openFlightOne,
            $originLocationCodeOne, 
            $originDataOffsetTwo, 
            $originDepartureDateTimeTwo,
            $destinationLocationCodeTwo, 
            $flexibleFaresOnlyTwo, 
            $includeInterlineFlightsTwo,
            $openFlightTwo, 
            $originLocationCodeTwo, 
            $travelerInformationCode, 
            $travelerQuantity,
            $tripType
        );

        dd($xml);
    }

    public function getAvailabilityOW(GetAvailabilityOWRequest $request) {
        $originDateOffset = $request->input('originDateOffset'); 
        $departureDateTime = $request->input('departureDateTime'); 
        $destinationLocationCode = $request->input('destinationLocationCode');
        $flexibleFareOnly = $request->input('flexibleFareOnly'); 
        $includeInterlineFlights = $request->input('includeInterlineFlights'); 
        $openFlight = $request->input('openFlight');
        $originLocationCode = $request->input('originLocationCode'); 
        $passengerTypeCode = $request->input('passengerTypeCode'); 
        $passengerQuantity = $request->input('passengerQuantity'); 
        $tripType = $request->input('tripType');

        $xml = $this->getAvailabilityBuilder->getAvailabilityOW(
            $originDateOffset, 
            $departureDateTime, 
            $destinationLocationCode,
            $flexibleFareOnly, 
            $includeInterlineFlights, 
            $openFlight,
            $originLocationCode, 
            $passengerTypeCode, 
            $passengerQuantity, 
            $tripType
        );

        dd($xml);
    }

    public function getAvailabilityMD(GetAvailabilityMDRequest $request) {
        $originDataOffsetOne = $request->input('originDataOffsetOne'); 
        $departureDateTimeOne = $request->input('departureDateTimeOne');
        $destinationLocationCodeOne = $request->input('destinationLocationCodeOne');
        $flexibleFareOnlyOne = $request->input('flexibleFareOnlyOne'); 
        $includeInterlineFlightsOne = $request->input('includeInterlineFlightsOne'); 
        $openFlightOne = $request->input('openFlightOne');
        $originLocationCodeOne = $request->input('originLocationCodeOne'); 
        $originDataOffsetTwo = $request->input('originDataOffsetTwo'); 
        $departureDateTimeTwo = $request->input('departureDateTimeTwo'); 
        $destinationLocationCodeTwo = $request->input('destinationLocationCodeTwo');
        $flexibleFareOnlyTwo = $request->input('flexibleFareOnlyTwo'); 
        $includeInterlineFlightsTwo = $request->input('includeInterlineFlightsTwo'); 
        $openFlightTwo = $request->input('openFlightTwo');
        $originLocationCodeTwo = $request->input('originLocationCodeTwo'); 
        $passengerTypeCode = $request->input('passengerTypeCode'); 
        $passengerQuantity = $request->input('passengerQuantity');
        $tripType = $request->input('tripType');

        $xml = $this->getAvailabilityBuilder->getAvailabilityMD(
            $originDataOffsetOne, 
            $departureDateTimeOne,
            $destinationLocationCodeOne,
            $flexibleFareOnlyOne, 
            $includeInterlineFlightsOne, 
            $openFlightOne,
            $originLocationCodeOne, 
            $originDataOffsetTwo, 
            $departureDateTimeTwo, 
            $destinationLocationCodeTwo,
            $flexibleFareOnlyTwo, 
            $includeInterlineFlightsTwo, 
            $openFlightTwo,
            $originLocationCodeTwo, 
            $passengerTypeCode, 
            $passengerQuantity,
            $tripType
        );

        dd($xml);
    }

    public function getAvailabilityTwoA(GetAvailabilityTwoARequest $request){
        $dataOffset = $request->input('dataOffset'); 
        $departureDateTime = $request->input('departureDateTime'); 
        $destinationLocationCode = $request->input('destinationLocationCode'); 
        $flexibleFareOnly = $request->input('flexibleFareOnly'); 
        $includeInterlineFlights = $request->input('includeInterlineFlights'); 
        $openFlight = $request->input('openFlight'); 
        $originLocationCode = $request->input('originLocationCode'); 
        $adultPassengerTypeCode = $request->input('adultPassengerTypeCode'); 
        $adultQuantity = $request->input('adultQuantity');
        $childPassengerTypeCode = $request->input('childPassengerTypeCode'); 
        $childQuantity = $request->input('childQuantity'); 
        $infantPassengerTypeCode = $request->input('infantPassengerTypeCode');
        $infantQuantity = $request->input('infantQuantity'); 
        $tripType = $request->input('tripType');

        $xml = $this->getAvailabilityBuilder->getAvailabilityTwoA(
            $dataOffset, 
            $departureDateTime, 
            $destinationLocationCode, 
            $flexibleFareOnly, 
            $includeInterlineFlights, 
            $openFlight, 
            $originLocationCode, 
            $adultPassengerTypeCode, 
            $adultQuantity,
            $childPassengerTypeCode, 
            $childQuantity, 
            $infantPassengerTypeCode,
            $infantQuantity, 
            $tripType
        );

        dd($xml);
    }
}
