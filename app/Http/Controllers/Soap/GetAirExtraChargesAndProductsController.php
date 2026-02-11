<?php

namespace App\Http\Controllers\Soap;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Soap\GetAirExtraChargesAndProductBuilder;
use App\Http\Requests\Soap\GetExtraChargesAndProductRequest;
class GetAirExtraChargesAndProductsController extends Controller
{
    protected $getAirExtraChargesAndProductBuilder;
    
    protected $craneOTASoapService;

    public function __construct(GetAirExtraChargesAndProductBuilder $getAirExtraChargesAndProductBuilder)
    {
        $this->getAirExtraChargesAndProductBuilder = $getAirExtraChargesAndProductBuilder;
        
        $this->craneOTASoapService = app('CraneOTASoapService');
    }

    
    public function getAirExtraChargesAndProduct(GetExtraChargesAndProductRequest $request) {

        $preferredCurrency = $request->input('preferredCurrency');
        $bookFlightSegmentList = $request->input('bookFlightSegmentList');       
        $locationCode = $request->input('locationCode');
        $passengerTypeQuantityList = $request->input('passengerTypeQuantityList'); 
        $tripType = $request->input('tripType');

        $xml = $this->getAirExtraChargesAndProductBuilder->getExtraChargesAndProduct(
            $preferredCurrency,
            $bookFlightSegmentList,       
            $locationCode,
            $passengerTypeQuantityList,
            $tripType
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAirExtraChargesAndProducts';
    

        $response = $this->craneOTASoapService->run($function, $xml);
        
        return $response;
    }


   

   

   


    

}
