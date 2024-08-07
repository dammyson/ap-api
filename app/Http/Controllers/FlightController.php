<?php

namespace App\Http\Controllers;

use App\Http\Requests\Passenger\SearchFlightRequest;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\FlightTicketType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\Http\SoapClientService;
use App\Services\Soap\SoapRequestBuilder;

class FlightController extends Controller
{
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $soapRequestBuilder;

    public function __construct(SoapRequestBuilder $soapRequestBuilder)
    {
        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->soapRequestBuilder = $soapRequestBuilder;
    }
    /**
     * Search for flights based on provided criteria.
     */
    public function searchFlights(SearchFlightRequest $request)
    {
        $departureDateTime = $request->input('departure_date');
        $ArrivalDateTime = $request->input('arrival_date');
        $destinationLocationCode = $request->input('departure_airport');
        $originLocationCode = $request->input('arrival_airport');
        $passengerTypeCode = $request->input('passenger_type');
        $quantity = $request->input('passengers');
        $tripType = $request->input('trip_type');;

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailability'; 

        if($request->input('trip_type') == "ONE_WAY"){
            $xml = $this->soapRequestBuilder->GetFlightOneWay($departureDateTime, $destinationLocationCode, $originLocationCode, $passengerTypeCode, $quantity, $tripType);  
        }else{
            $xml = $this->soapRequestBuilder->GetFlightRoundTrip($departureDateTime, $destinationLocationCode, $originLocationCode, $passengerTypeCode, $quantity, $tripType,  $ArrivalDateTime);  
        }
         

        try {
            $response = $this->craneOTASoapService->run($function, $xml);

            $step1= $response['Availability']['availabilityResultList']['availabilityRouteList']['availabilityByDateList']['originDestinationOptionList'];
            $step2= $step1[0]['fareComponentGroupList'];
           // $step3 = $this->groupFaresByCabin($step2);

            return response()->json($step2);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }


    public function groupFaresByCabin( $fareInfoList)
    {
        $groupedFares = null;
       
        return $groupedFares;
    }
}
