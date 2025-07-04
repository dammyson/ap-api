<?php

namespace App\Http\Controllers\Soap;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\AvailableSpecial\AvailableSpecialServiceOWRequest;
use App\Http\Requests\Test\AvailableSpecial\AvailableSpecialServiceRTRequest;
use App\Http\Requests\Test\AvailableSpecial\AvailableSpecialServiceTwoARequest;
use App\Services\Soap\AvailableSpecialServiceBuilder;
use Illuminate\Http\Request;

class AvailableSpecialController extends Controller
{
    protected $availableSpecialServiceBuilder;
    protected $craneAncillaryOTASoapService;

    public function __construct(AvailableSpecialServiceBuilder $availableSpecialServiceBuilder)    {
        $this->availableSpecialServiceBuilder = $availableSpecialServiceBuilder;
        
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }

    public function AvailableSpecialServiceTwoA (AvailableSpecialServiceTwoARequest $request) {
        $ID = $request->input("ID"); 
        $referenceID = $request->input("referenceID");

        $xml = $this->availableSpecialServiceBuilder->AvailableSpecialServiceTwoA(
            $ID, 
            $referenceID
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailableSpecialServices';

        $response  =  $this->craneAncillaryOTASoapService->run($function, $xml);
        return $response;
    }

    public function AvailableSpecialServiceOW(AvailableSpecialServiceOWRequest $request) {
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID');   

        $xml = $this->availableSpecialServiceBuilder->AvailableSpecialServiceOW(
            $ID, 
            $referenceID
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

    public function AvailableSpecialServiceRT(AvailableSpecialServiceRTRequest $request) {
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID');

        $xml = $this->availableSpecialServiceBuilder->AvailableSpecialServiceRT(
            $ID, 
            $referenceID
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailableSpecialServices';

        $response  =  $this->craneAncillaryOTASoapService->run($function, $xml);
        return $response;
    }
}
