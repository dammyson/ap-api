<?php

namespace App\Http\Controllers\Guest;

use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ScreenResolution;
use App\Http\Controllers\Controller;
use App\Services\AutoGenerate\CreatePeaceId;
use App\Services\AutoGenerate\GeneratePassword;

class GuestLoginController extends Controller
{
    protected $createPeaceId;
    protected $generatePassword;

    public function __construct(CreatePeaceId $createPeaceId, GeneratePassword $generatePassword) {
        $this->createPeaceId = $createPeaceId;
        $this->generatePassword = $generatePassword;
    }

    public function continueAsGuest(Request $request) {
        try {
           
         $deviceType = $request->input('device_type');
         $screenResolution = $request->input('screen_resolution');
         
        // dd($this->createPeaceId->generateUniqueEmail());\
        $guestPassword = $this->generatePassword->generateTemporaryPassword();
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
        
       
     } catch (\Exception $exception) {
         return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
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
