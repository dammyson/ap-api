<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use App\Services\Utility\CheckDevice;

use App\Services\Utility\CheckDevice;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Models\ScreenResolution;
use App\Notifications\PasswordChanged;
use App\Services\Point\TierPointService;

class LoginController extends Controller
{
    // protected $checkDevice;
    // public function __construct(CheckDevice $checkDevice) {
    //     $this->$checkDevice = $checkDevice;
    // }

    protected $tierService;

    public function __construct(TierPointService $tierService)
    {
        $this->tierService = $tierService;
    }
    //
    public function login(UserLoginRequest $request)
    {
        try{
            $deviceType = $request->input('device_type');
            $screenResolution = $request->input('screen_resolution');
            // $user = User::where('email', $request->credential);
            $user = User::where(function ($query) use ($request) {
                $query->where('email', $request->credential)
                    ->orWhere('peace_id', $request->peace_id);
            })->first();


            $details = [
                'title' => 'New Message',
                'body' => 'You have received a new message.',
                'url' => '/messages/1'
            ];

            $user->notify(new PasswordChanged($details));

            // dd('');

            if (is_null($user)) {
                return response()->json(['error' => true, 'message' => 'Invalid credentials'], 401);
            }
            $currentTier = $user->currentTier();
            
            if(!$currentTier) {
                $this->tierService->assignTierWithDefaultFallback($user->id);
            }
           
            // $newpassword = $validated['password'];
            // dd($newpassword);
            if (Hash::check($request["password"], $user->password)) {
                $data['user'] = $user;
                $data['token'] = $user->createToken('Nova')->accessToken;

                // $userAgent = $request->header('User-Agent');
                
                // $deviceType = $this->checkDevice->checkDeviceType($userAgent, $user);
                // $screenResolution = $this->checkDevice->saveScreenSize($user, $request->screen_resolution);
                

                
                if ($deviceType) {
                    $userDevice = Device::where('user_id', $user->id)->first();
                    $user->device_type = $deviceType;
                    $user->save();

                    if (!$userDevice) {
                        Device::create([
                            'user_id' => $user->id,
                            'device_type' => $deviceType
                        ]);
                    } else {
                        $userDevice->device_type = $deviceType;
                        $userDevice->save();
                    }
                }

                if ($screenResolution) {
                    $userScreenResolution = ScreenResolution::where('user_id', $user->id)->first();

                    if(!$userScreenResolution) {
                        ScreenResolution::create([
                            'user_id' => $user->id,
                            'screen_resolution' => $screenResolution
                        ]);
                    } else {
                        $userScreenResolution->screen_resolution = $screenResolution;
                        $userScreenResolution->save();
                    }
                }

                return response()->json([
                    'is_correct' => true, 
                    'message' => 'Login Successful', 
                    // 'deviceType' => $deviceType,
                    // 'screenResolution' => $screenResolution,
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
