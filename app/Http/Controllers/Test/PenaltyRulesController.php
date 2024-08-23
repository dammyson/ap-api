<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Penalty\PenaltyRulesRequest;
use App\Services\Soap\PenaltyRulesBuilder;
use Illuminate\Http\Request;

class PenaltyRulesController extends Controller
{
    protected $penaltyRulesBuilder;

    public function __construct(PenaltyRulesBuilder $penaltyRulesBuilder)
    {
        $this->penaltyRulesBuilder = $penaltyRulesBuilder;
    }

    public function penaltyRules(PenaltyRulesRequest $request) {
        $fareBasisCode = $request->input('fareBasisCode');
       
        $xml = $this->penaltyRulesBuilder->penaltyRules($fareBasisCode);


         try {

            dd($xml);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
