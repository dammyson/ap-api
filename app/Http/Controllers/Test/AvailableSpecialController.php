<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\AvailableSpecial\AvailableSpecialServiceOWRequest;
use App\Http\Requests\Test\AvailableSpecial\AvailableSpecialServiceRTRequest;
use App\Http\Requests\Test\AvailableSpecial\AvailableSpecialServiceTwoARequest;
use App\Services\Soap\AvailableSpecialServiceBuilder;
use Illuminate\Http\Request;

class AvailableSpecialController extends Controller
{
    protected $availableSpecialServiceBuilder;

    public function __construct(AvailableSpecialServiceBuilder $availableSpecialServiceBuilder)
    {
        $this->availableSpecialServiceBuilder = $availableSpecialServiceBuilder;
    }

    public function AvailableSpecialServiceTwoA (AvailableSpecialServiceTwoARequest $request) {
        $cityCode = $request->input("cityCode"); 
        $code = $request->input("code"); 
        $codeContext = $request->input("code"); 
        $companyFullName = $request->input("companyFullName");
        $companyShortName = $request->input("companyShortName"); 
        $countryCode = $request->input("countryCode"); 
        $ID = $request->input("ID"); 
        $referenceID = $request->input("referenceID");

        $xml = $this->availableSpecialServiceBuilder->AvailableSpecialServiceTwoA(
            $cityCode, 
            $code, 
            $codeContext, 
            $companyFullName,
            $companyShortName, 
            $countryCode, 
            $ID, 
            $referenceID
        );

        dd($xml);
    }

    public function AvailableSpecialServiceOW(AvailableSpecialServiceOWRequest $request) {
        $cityCode = $request->input('cityCode'); 
        $code = $request->input('code'); 
        $codeContext = $request->input('codeContext'); 
        $companyFullName = $request->input('companyFullName'); 
        $companyShortName = $request->input('companyShortName'); 
        $companyCountryCode = $request->input('companyCountryCode'); 
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID');   

        $xml = $this->availableSpecialServiceBuilder->AvailableSpecialServiceOW(
            $cityCode, 
            $code, 
            $codeContext, 
            $companyFullName, 
            $companyShortName, 
            $companyCountryCode, 
            $ID, 
            $referenceID
        );

        dd($xml);
    }

    public function AvailableSpecialServiceRT(AvailableSpecialServiceRTRequest $request) {
        $cityCode = $request->input('cityCode'); 
        $code = $request->input('code'); 
        $codeContext = $request->input('codeContext'); 
        $companyFullName = $request->input('companyFullName'); 
        $companyShortName = $request->input('companyShortName'); 
        $countryCode = $request->input('countryCode'); 
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID');

        $xml = $this->availableSpecialServiceBuilder->AvailableSpecialServiceRT(
            $cityCode, 
            $code, 
            $codeContext, 
            $companyFullName, 
            $companyShortName, 
            $countryCode, 
            $ID, 
            $referenceID
        );

        return $xml;
    }
}
