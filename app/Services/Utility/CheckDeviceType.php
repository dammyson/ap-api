<?php

namespace App\Services\Utility;

use App\Models\User;
use App\Models\Device;
use App\Models\ScreenResolution;
use Illuminate\Http\Request;

class CheckDevice {
    public function checkDeviceType($userAgent, User $user) {        

        // $userAgent = $request->header('User-Agent');
        $userDevice = Device::where('user_id', $user->id)->first();
        if (strpos($userAgent, 'Android') !== false) {
            $deviceType = 'Android';
        
        } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            $deviceType = 'IOS';
        
        } else {
            $deviceType = 'Android';
        }

        if (!$userDevice) {
            Device::create([
                'user_id' => $user->id,
                'device_type' => $deviceType
            ]);

        } else {
            if ($userDevice->device_type !== $deviceType) {
                $userDevice->device_type = $deviceType;
                $userDevice->save();                
            }
        }

        return $deviceType;
    }

    public function saveScreenSize(User $user, $screenResolution) {
        $userScreen = ScreenResolution::where('user_id', $user->id)->first();
        if (!$userScreen) {
            ScreenResolution::create([
                'user_id' => $user->id,
                'screen_resolution' => $screenResolution
            ]);

        } else {
            if ($userScreen->screen_resolution !== $screenResolution) {
                $userScreen->screen_resolution = $screenResolution;
                $userScreen->save();
            }
        }

        return $screenResolution;
    }
}