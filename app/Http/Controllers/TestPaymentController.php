<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\Wallet\TopUpService;
use App\Services\Wallet\VerificationService;

class TestPaymentController extends Controller
{
   
    public function verify($ref)
    {
        $user_id = Auth::user()->id;
        // $wallet = Wallet::where('user_id', $user_id)->get();
       
        try {
            $new_top_request = new VerificationService($ref);
            $verified_request = $new_top_request->run();
            dd($verified_request);
            $top_up  =  new TopUpService($verified_request,  $wallet);             
            $top_up_result =  $top_up->run();
            return response()->json(['status' => true, 'data' =>  $top_up_result, 'message' => 'Wallet top up successfully'], 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['status' => false,  'message' => 'Error processing request'], 500);
        }
    }

}