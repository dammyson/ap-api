<?php

namespace App\Http\Controllers\Soap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Soap\SegmentBaseRequestBuilder;
use App\Http\Requests\Test\SegmentBase\SegmentBaseAvailableSpecialServicesRequest;

class SegmentBaseController extends Controller
{
    protected $segmentBaseRequestBuilder;
    protected $craneAncillaryOTASoapService;

    public function __construct(SegmentBaseRequestBuilder $segmentBaseRequestBuilder)
    {
        $this->segmentBaseRequestBuilder = $segmentBaseRequestBuilder;
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }

    public function segmentBaseAvailableSpecialServices(SegmentBaseAvailableSpecialServicesRequest $request) {
        


        $xml = $this->segmentBaseRequestBuilder->segmentBaseAvailableSpecialServices(
            $request
        );

        // dd($xml);
         

        try {

            // dd("I ran");
            $function = 'http://impl.soap.ws.crane.hititcs.com/SegmentBaseAvailableSpecialServices';

            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            return $response;

            $availableSSRList = $response['SegmentBaseAvailableSpecialServicesResponse']['availSpecialServices']['availSpecialServiceList']['availableSSRList'];
            
            return response()->json([
                "error" => false,
                "available_ssr_list" => $availableSSRList
            ], 200);
            
            
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }
    
}
