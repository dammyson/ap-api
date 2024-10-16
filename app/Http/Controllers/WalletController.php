<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function createWallet(Request $request) {
        $user = $request->user();

        try {
            
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0.0, 
                'ledger_balance' => 0.0
            ]);
    
            return response()->json([
                'error' => false,
                'message' => 'wallet created successfully',
                'wallet' => $wallet
            ], 200);
        
        }catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
        
    }
}
