<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile(Request $request) {
        try {
            $user = $request->user();

            return response()->json([
                "error" => "false",
                "user" => $user
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }
       
    }
}
