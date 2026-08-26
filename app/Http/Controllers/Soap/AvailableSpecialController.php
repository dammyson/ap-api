<?php

namespace App\Http\Controllers\Soap;

use App\Http\Controllers\Controller;
use App\Http\Requests\Soap\AvailableSpecial\AvailableSpecialServiceRequest;
use App\Services\Soap\AvailableSpecialServiceBuilder;
use Illuminate\Support\Facades\Log;

class AvailableSpecialController extends Controller
{
    protected $availableSpecialServiceBuilder;
    protected $craneAncillaryOTASoapService;

    public function __construct(AvailableSpecialServiceBuilder $availableSpecialServiceBuilder)    {
        $this->availableSpecialServiceBuilder = $availableSpecialServiceBuilder;
        
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }
   

    public function AvailableSpecialService(AvailableSpecialServiceRequest $request) {
        try {

            $xml = $this->availableSpecialServiceBuilder->AvailableSpecialService(
              $request
            );
    
            $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailableSpecialServices';
    
            $response  =  $this->craneAncillaryOTASoapService->run($function, $xml);
    
            return $response;
        } catch (\Throwable $th) {

            Log::error('ERROR RETRIEVING SURVEYS', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
       
    }

  
}
