<?php

namespace App\Http\Controllers\Soap;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Soap\GetAvailabilityBuilder;

class GetAvailabilityController extends Controller
{
    //
    protected $getAvailabilityBuilder;
    protected $craneOTASoapService;

    public function __construct(GetAvailabilityBuilder $getAvailabilityBuilder)
    {
        $this->getAvailabilityBuilder = $getAvailabilityBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
    }

    public function getAvailabilityGeneralParameters() {
        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailabilityGeneralParameters';
        $xml = $this->getAvailabilityBuilder->getAvailabilityGeneralParameters();
        try {

            $response = $this->craneOTASoapService->run($function, $xml);
            // dd($response);
            return $response;
           

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }
}
