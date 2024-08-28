<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Services\Soap\GetAirportMatrixBuilder;
use Illuminate\Http\Request;

class GetAirportMatrixController extends Controller
{
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $getAirportBuilder;

    public function __construct(GetAirportMatrixBuilder $getAirportBuilder)
    {
        $this->getAirportBuilder = $getAirportBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');  
    }

    public function GetAirportMatrix() {
        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAirPortMatrix';
        $xml = $this->getAirportBuilder->GetAirportMatrix();
 
        $response = $this->craneOTASoapService->run($function, $xml);

        dd($response);
    }
}
