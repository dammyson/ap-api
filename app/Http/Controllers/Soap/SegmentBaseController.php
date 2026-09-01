<?php

namespace App\Http\Controllers\Soap;

use App\Exceptions\HititException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Soap\SegmentBaseRequestBuilder;
use App\Http\Requests\Soap\SegmentBase\SegmentBaseAvailableSpecialServicesRequest;
use App\Services\Utility\FlightNotes;

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
        

        try {

            $xml = $this->segmentBaseRequestBuilder->segmentBaseAvailableSpecialServices(
                $request
            );

            $function = 'http://impl.soap.ws.crane.hititcs.com/SegmentBaseAvailableSpecialServices';

            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            
            return $response;
            
            
        } catch (HititException $e) {
            
            Log::error('HITIT ERROR RETRIEVING SEGMENT BASE AVAILABLE SPECIAL SERVICES', [
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

            Log::error('ERROR RETRIEVING SEGMENT BASE AVAILABLE SPECIAL SERVICES', [
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