<?php

namespace App\Http\Controllers\Soap;

use App\Http\Controllers\Controller;
use App\Http\Requests\Soap\AvailableSpecial\AvailableSpecialServiceRequest;
use App\Services\Soap\AvailableSpecialServiceBuilder;

class AvailableSpecialController extends Controller
{
    protected $availableSpecialServiceBuilder;
    protected $craneAncillaryOTASoapService;

    public function __construct(AvailableSpecialServiceBuilder $availableSpecialServiceBuilder)    {
        $this->availableSpecialServiceBuilder = $availableSpecialServiceBuilder;
        
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }
   

    public function AvailableSpecialService(AvailableSpecialServiceRequest $request) {

        $xml = $this->availableSpecialServiceBuilder->AvailableSpecialService(
          $request
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailableSpecialServices';

        $response  =  $this->craneAncillaryOTASoapService->run($function, $xml);

        return $response;
        // $availableSSRList = $response["AirAvailSpecialServicesResponse"]["availSpecialServices"]["availSpecialServiceList"]["availableSSRList"];

        // $baggageData = '';
        // foreach($availableSSRList as $availableSSR) {
        //     if ($availableSSR["code"] == "XBAG") {
        //         $baggageData = $availableSSR;
        //         break;
        //     }
        // }

        // return $baggageData;
    }

  
}
