<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\Admin\LoginAdminRequest;
use App\Models\Admin;

class LoginAdminController extends Controller
{
    public function loginAdmin(LoginAdminRequest $request) {
        try {
            $admin = Admin::where('email', $request->email)->first();

            if (is_null($admin)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Invalid credential'
                ]);
            }


            if (Hash::check($request->password, $admin->password)) {
                $data['admin'] = $admin;
                $data['token'] = $admin->createToken('Nova')->accessToken;

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

        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);

        }
    }
}
