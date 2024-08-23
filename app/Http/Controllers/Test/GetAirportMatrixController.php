<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Services\Soap\GetAirportMatrixBuilder;
use Illuminate\Http\Request;

class GetAirportMatrixController extends Controller
{
    protected $getAirportBuilder;

    public function __construct(GetAirportMatrixBuilder $getAirportBuilder)
    {
        $this->getAirportBuilder = $getAirportBuilder;
    }

    public function GetAirportMatrix() {
        $xml = $this->getAirportBuilder->GetAirportMatrix();

        dd($xml);
    }
}
