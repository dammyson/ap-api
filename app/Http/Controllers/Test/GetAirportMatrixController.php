<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Services\Soap\GetAirportMatrixBuilder;
use Illuminate\Http\Request;

class GetAirportMatrixController extends Controller
{
    protected $getAirportBuilder;
    protected $craneOTASoapService;
       

    public function __construct(GetAirportMatrixBuilder $getAirportBuilder)
    {
        $this->getAirportBuilder = $getAirportBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
    }

    public function GetAirportMatrix() {
        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAirPortMatrix';
        $xml = $this->getAirportBuilder->GetAirportMatrix();

        try {
            $response = $this->craneOTASoapService->run($function, $xml);
            $airportMatrixList = $response['AirPortMatrixResponse']['airPortMatrixInfo']['airPortMatrixList'];
            $availableFlights = [];
            
            foreach($airportMatrixList as $airportMatrix) {
                $originLocationCityCode =  $airportMatrix['origin']['city']['locationCode'];
                $originLocationCityName = $airportMatrix['origin']['city']['locationName'];
                $originLocationCountryCode = $airportMatrix['origin']['country']['locationCode'];
                $originLocationCountryName = $airportMatrix['origin']['country']['locationName'];
            
                $departureFlights = $airportMatrix['destinationList'];
                $departureFlightArray = [];

                if (array_key_exists('city', $departureFlights)) {
                    $departureCityLocationCode = $departureFlights['city']['locationCode'];
                    $departureCityLocationName = $departureFlights['city']['locationName'];
                    $departureCountryLocationCode = $departureFlights['country']['locationCode'];
                    $departureCountryLocationName = $departureFlights['country']['locationName'];
                    
                    $departureFlightArray[] = [
                        "departureCityLocationCode" => $departureCityLocationCode,
                        "departureCityLocationName" => $departureCityLocationName,
                        "departureCountryLocationCode" => $departureCountryLocationCode,
                        "departureCountryLocationName" => $departureCountryLocationName
                    ];
                } else  {
                    foreach($departureFlights as $departureFlight) {
                        $departureCityLocationCode = $departureFlight['city']['locationCode'];
                        $departureCityLocationName = $departureFlight['city']['locationName'];
                        $departureCountryLocationCode = $departureFlight['country']['locationCode'];
                        $departureCountryLocationName = $departureFlight['country']['locationName'];
                        
                        $departureFlightArray[] = [
                            "departureCityLocationCode" => $departureCityLocationCode,
                            "departureCityLocationName" => $departureCityLocationName,
                            "departureCountryLocationCode" => $departureCountryLocationCode,
                            "departureCountryLocationName" => $departureCountryLocationName
                        ];
                    } 
                }

                $availableFlightDetails = [
                    "originAndDestinations"  => [
                        "originLocationCityCode" => $originLocationCityCode,
                        "originLocationCityName" => $originLocationCityName,
                        "originLocationCountryCode" => $originLocationCountryCode,
                        "originLocationCountryName" => $originLocationCountryName,
                        "destinations" => $departureFlightArray
                    ]                    
                ];

                $availableFlights[] = $availableFlightDetails;
            }
        
        } catch (\Throwable $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ], 500);

        }

        return response()->json([
            "error" => "false",
            "message" => "available flights",
            "availableFlights" => $availableFlights
        ], 200);

    }
}
