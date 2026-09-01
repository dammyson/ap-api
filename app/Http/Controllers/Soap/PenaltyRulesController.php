<?php

namespace App\Http\Controllers\Soap;

use App\Exceptions\HititException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Soap\PenaltyRulesBuilder;
use App\Http\Requests\Soap\Penalty\PenaltyRulesRequest;

class PenaltyRulesController extends Controller
{
    protected $penaltyRulesBuilder;
    protected $craneFareRulesService;

    public function __construct(PenaltyRulesBuilder $penaltyRulesBuilder)
    {
        $this->penaltyRulesBuilder = $penaltyRulesBuilder;
        $this->craneFareRulesService = app('CraneFareRulesService');
    }

    public function penaltyRules(PenaltyRulesRequest $request) {
        try {

            $fareBasisCode = $request->input('fareBasisCode');
       
            $function = 'http://impl.soap.ws.crane.hititcs.com/PenaltyRules';
            $xml = $this->penaltyRulesBuilder->penaltyRules($fareBasisCode);

            $response = $this->craneFareRulesService->run($function, $xml);

         
            return $response;

        } catch (HititException $e) {
            
            Log::error('HITIT ERROR RETRIEVING PENALTY RULES', [
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

            Log::error('ERROR RETRIEVING PENALTY RULES', [
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
