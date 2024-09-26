<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Penalty\PenaltyRulesRequest;
use App\Services\Soap\PenaltyRulesBuilder;
use Illuminate\Http\Request;

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
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
