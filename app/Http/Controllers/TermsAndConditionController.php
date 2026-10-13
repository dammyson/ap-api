<?php

namespace App\Http\Controllers;

use App\Models\InsuranceTermsAndConditions;
use App\Models\InsuTermsAndConds;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{
    public function getSignUpTermsAndCondition() {
        return TermsAndCondition::select([
                'id',
                'content',
            ])
            ->where('effective_at', '<=', now())
            ->orderByDesc('effective_at')
            ->first();
    }

    public function getInsuranceTermsAndCondition() {
        return InsuTermsAndConds::select([
                'id',
                'content',
            ])
            ->where('effective_at', '<=', now())
            ->orderByDesc('effective_at')
            ->first();
    }
}
