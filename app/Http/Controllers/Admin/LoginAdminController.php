<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Events\AdminLoginEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\Admin\LoginAdminRequest;

class LoginAdminController extends Controller
{
    public function loginAdmin(LoginAdminRequest $request) {
        try {
            $admin = Admin::where('email', $request->email)->first();

            // dd($admin);

            if (is_null($admin)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid credential'
                ]);
            }

            if (Hash::check($request->password, $admin->password)) {
                $data['admin'] = $admin;
                $data['token'] = $admin->createToken('Nova')->accessToken;

                event(new AdminLoginEvent($admin));
                
                return response()->json(
                    [
                        'is_correct' => true,
                        'message' => 'Admin login successfully',
                        'data' => $data
                    ], 200
                );
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid credentials'
                ], 401);
            }

        } catch (\Exception $e) {       
            
            Log::error($e->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
            
        }
    }
}
