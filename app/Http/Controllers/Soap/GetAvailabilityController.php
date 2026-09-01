<?php

namespace App\Http\Controllers\Soap;

use App\Exceptions\HititException;
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
        try {
            
            $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailabilityGeneralParameters';
            $xml = $this->getAvailabilityBuilder->getAvailabilityGeneralParameters();
       

            $response = $this->craneOTASoapService->run($function, $xml);

            return $response;           

        } catch (HititException $e) {
            
            Log::error('HITIT RETRIEVING GENERAL AVAILABILITY PARAMETERS', [
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
            ], 400);

        } catch (\Throwable $th) {

            Log::error('ERROR RETRIEVING GENERAL AVAILABILITY PARAMETERS', [
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
