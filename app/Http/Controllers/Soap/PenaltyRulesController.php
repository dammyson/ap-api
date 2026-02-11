<?php

namespace App\Http\Controllers\Soap;

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
        $fareBasisCode = $request->input('fareBasisCode');
       
        $function = 'http://impl.soap.ws.crane.hititcs.com/PenaltyRules';
        $xml = $this->penaltyRulesBuilder->penaltyRules($fareBasisCode);

        $response = $this->craneFareRulesService->run($function, $xml);

         try {

            dd($response);
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  

    }
}
