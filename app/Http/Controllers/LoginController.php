<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\Utility\CheckDevice;

class LoginController extends Controller
{
    public $checkDevice;
    public function __construct(CheckDevice $checkDevice) {
        $this->$checkDevice = $checkDevice;
    }

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

                $userAgent = $request->header('User-Agent');
                
                $deviceType = $this->checkDevice->checkDeviceType($userAgent, $user);
                $screenResolution = $this->checkDevice->saveScreenSize($user, $request->screen_resolution);
                
                return response()->json([
                    'is_correct' => true, 
                    'message' => 'Login Successful', 
                    'deviceType' => $deviceType,
                    'screenResolution' => $screenResolution,
                    'data' => $data
                ], 200);

            } else {
                return response()->json(['error' => true, 'message' => 'Invalid credentials'], 401);
            }
        }catch(\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }
}
