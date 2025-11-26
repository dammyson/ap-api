<?php

namespace App\Http\Controllers\Soap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Soap\SeatMapBuilder;
use App\Http\Requests\Test\seatMapRequest;

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

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetSeatMap';

        $xml = $this->seatMapBuilder->seatMap($request);

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            
            // Check if there's a SOAP fault in the response
            if (
                isset($response['faultcode']) &&
                isset($response['detail']['CraneFault']['code']) &&
                $response['detail']['CraneFault']['code'] === 'SEAT_MAP_FREE_SEAT_FLIGHT'
            ) {
                return response()->json([
                    "error" => true,
                    "message" => "seat selection unavailable, please try again later"
                ], 400); // You can adjust status code (e.g., 422 or 404 if preferred)
            }
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
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "seat selection unavailable, please try again later"
            ], 500);
        }  
    }    
}
