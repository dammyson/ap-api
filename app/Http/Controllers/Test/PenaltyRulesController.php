<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Penalty\PenaltyRulesRequest;
use App\Services\Soap\PenaltyRulesBuilder;
use Illuminate\Http\Request;

class PenaltyRulesController extends Controller
{
    protected $penaltyRulesBuilder;
    protected $craneFareRulesSoapService;

    public function __construct(PenaltyRulesBuilder $penaltyRulesBuilder)
    {
        $this->penaltyRulesBuilder = $penaltyRulesBuilder;
        $this->craneFareRulesSoapService = app('CraneFareRulesSoapService'); 
    }

    public function penaltyRules(PenaltyRulesRequest $request) {
        $fareBasisCode = $request->input('fareBasisCode');

        $function = 'http://schemas.xmlsoap.org/soap/envelope/PenaltyRules';
       
        $xml = $this->penaltyRulesBuilder->penaltyRules($fareBasisCode);


         try {     
            $response = $this->craneFareRulesSoapService->run($function, $xml);
            dd($response);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
