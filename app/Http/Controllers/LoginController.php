<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    //
    public function login(UserLoginRequest $request)
    {
        try{
            // $user = User::where('email', $request->credential);
            $user = User::where(function ($query) use ($request) {
                $query->where('email', $request->credential)
                    ->orWhere('peace_id', $request->peace_id);
            })->first();

            if (is_null($user)) {
                return response()->json(['error' => true, 'message' => 'Invalid credentials'], 401);
            }
            // $newpassword = $validated['password'];
            // dd($newpassword);
            if (Hash::check($request["password"], $user->password)) {
                $data['user'] = $user;
                $data['token'] = $user->createToken('Nova')->accessToken;

                return response()->json(['is_correct' => true, 'message' => 'Login Successful', 'data' => $data], 200);

            } else {
                return response()->json(['error' => true, 'message' => 'Invalid credentials'], 401);
            }
        }catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }
}
