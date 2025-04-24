<?php

namespace App\Http\Controllers\Guest;

use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ScreenResolution;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\AutoGenerate\CreatePeaceId;
use App\Services\AutoGenerate\GeneratePassword;
use App\Services\AutoGenerate\GenerateRandom;

class GuestLoginController extends Controller
{
    protected $createPeaceId;
    protected $generateRandom;

    public function __construct(CreatePeaceId $createPeaceId, GenerateRandom $generateRandom) {
        $this->createPeaceId = $createPeaceId;
        $this->generateRandom = $generateRandom;
    }

    public function continueAsGuest(Request $request) {
        try {
         $deviceType = $request->input('device_type');
         $screenResolution = $request->input('screen_resolution');
         
        $guestPassword = $this->generateRandom->generateTemporaryPassword();
         $create = User::create([
             'first_name' => $this->createPeaceId->generateName(),
             'last_name' => $this->createPeaceId->generateName(),
             'email' => $this->createPeaceId->generateUniqueEmail(),
             'phone_number' => $this->createPeaceId->generateUniquePhoneNo(),
             'peace_id' => $this->createPeaceId->generateUniquePeaceId(),
             // 'peace_id' => $peace_id,
             'password' => $guestPassword,
             'status' => $request->input('status') ?? null,
             'device_type' => $deviceType,
             'is_guest' => true
         
         ]);

         if ($deviceType) {
             Device::create([
                 'user_id' => $create->id,
                 'device_type' => $deviceType
             ]);

         }

         if ($screenResolution) {
             ScreenResolution::create([
                 'user_id' => $create->id,
                 'screen_resolution' => $screenResolution
             ]);
         }
        
       
     } catch (\Exception $e) {       
            
        Log::error($e->getMessage());

        return response()->json([
            "error" => true,            
            "message" => "something went wrong",
            "actual_message" => $e->getMessage()
        ], 500);
        
    }

     $data['user'] =  $create;
     $data['token'] =  $create->createToken('Nova')->accessToken;

    return response()->json([
        'error' => false, 
        'message' => 'Client registration successful. Verification code sent to your email.', 
        'guest_password' => $guestPassword,
        'data' => $data,
        // 'device_type' => $deviceType,
        // 'screen_resolution' => $screenResolution
    ], 201);
    
    }

}
