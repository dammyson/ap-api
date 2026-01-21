<?php

namespace App\Http\Controllers\Soap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Soap\GetAirportMatrixBuilder;

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
            // dd($response);
            if(!array_key_exists('AirPortMatrixResponse', $response)) {
                return response()->json([
                    'error' => true,
                    'response' => $response
                ]);
            }
            $airportMatrixList = $response['AirPortMatrixResponse']['airPortMatrixInfo']['airPortMatrixList'];
            $availableFlights = [];
            
            foreach($airportMatrixList as $airportMatrix) {
                $originLocationCityCode =  $airportMatrix['origin']['city']['locationCode'];
                $originLocationCityName = $airportMatrix['origin']['city']['locationName'];
                $originLocationCountryCode = $airportMatrix['origin']['country']['locationCode'];
                $originLocationCountryName = $airportMatrix['origin']['country']['locationName'];

                $originPortLocationCode = $airportMatrix['origin']['port']['locationCode'];
                $originPortLocationNameLanguage= $airportMatrix['origin']['port']['locationName'];
             
                $destinationFlights = $airportMatrix['destinationList'];
                $destinationFlightArray = [];
                // $count = 0;

                if (array_key_exists('city', $destinationFlights)) {
                    $destinationCityLocationCode = $destinationFlights['city']['locationCode'];
                    $destinationCityLocationName = $destinationFlights['city']['locationName'];
                    $destinationCountryLocationCode = $destinationFlights['country']['locationCode'];
                    $destinationCountryLocationName = $destinationFlights['country']['locationName'];
                    $destinationPortLocationCode = $destinationFlights['port']['locationCode'];
                    $destinationPortLocationName = $destinationFlights['port']['locationName'];
                    
                    // dd("I ran");
                    $destinationFlightArray[] = [
                        "destinationCityLocationCode" => $destinationCityLocationCode,
                        "destinationCityLocationName" => $destinationCityLocationName,
                        "destinationCountryLocationCode" => $destinationCountryLocationCode,
                        "destinationCountryLocationName" => $destinationCountryLocationName,
                        "destinationPortLocationCode" => $destinationPortLocationCode,
                        "destinationPortLocationName" => $destinationPortLocationName
                    ];
                } else  {
                    foreach($destinationFlights as $destinationFlight) {
                        // dump("i ran");
                        $destinationCityLocationCode = $destinationFlight['city']['locationCode'];
                        $destinationCityLocationName = $destinationFlight['city']['locationName'];
                        $destinationCountryLocationCode = $destinationFlight['country']['locationCode'];
                        $destinationCountryLocationName = $destinationFlight['country']['locationName'];
                        $destinationPortLocationCode = $destinationFlight['port']['locationCode'];
                        $destinationPortLocationName = $destinationFlight['port']['locationName'];

                        $destinationFlightArray[] = [
                            "destinationCityLocationCode" => $destinationCityLocationCode,
                            "destinationCityLocationName" => $destinationCityLocationName,
                            "destinationCountryLocationCode" => $destinationCountryLocationCode,
                            "destinationCountryLocationName" => $destinationCountryLocationName,
                            "destinationPortLocationCode" => $destinationPortLocationCode,
                            "destinationPortLocationName" => $destinationPortLocationName
                        ];
                    } 
                }

                $availableFlightDetails = [
                    "originAndDestinations"  => [
                        "originLocationCityCode" => $originLocationCityCode,
                        "originLocationCityName" => $originLocationCityName,
                        "originLocationCountryCode" => $originLocationCountryCode,
                        "originLocationCountryName" => $originLocationCountryName,
                        "originPortLocationCode" => $originPortLocationCode,
                        "originPortLocationNameLanguage" => $originPortLocationNameLanguage,
                        "destinations" => $destinationFlightArray
                    ]                    
                ];

                $availableFlights[] = $availableFlightDetails;
            }

            return response()->json([
                "error" => "false",
                "message" => "available flights",
                "availableFlights" => $availableFlights
            ], 200);
        
        }  catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong",
                "actual_message" => $th->getMessage()
            ], 500);
        }  

      

    }
}
