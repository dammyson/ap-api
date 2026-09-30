<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Events\AdminLoginEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Admin\CreateAdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\Admin\LoginAdminRequest;

class LoginAdminController extends Controller
{
    public function loginAdmin(LoginAdminRequest $request) {
        try {
            
            $credentials = $request->only('email', 'password');

            // dd($credentials);

            if (!$token = auth('admin')->attempt($credentials)) {

                // dd("no token returned");
                return response()->json([
                    'error' => '',
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $admin = Admin::where('email', $request->email)->first();

            if (!$admin) {
                // dd("amdin not")
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid credentials'
                ], 401);

            }

            $data = [
                'admin' => $admin,
                'token' => $token
            ];

            event(new AdminLoginEvent($admin));
                
            return response()->json(
                [
                    'error' => false,
                    'message' => 'Admin login successfully',
                    'data' => $data
                ], 200
            );


        } catch (\Throwable $th) {       
            
            Log::error('LOGIN ERROR', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
            
        }
    }

}
