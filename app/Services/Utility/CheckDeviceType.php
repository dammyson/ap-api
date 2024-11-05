<?php

namespace App\Services\Utility;

use App\Models\User;
use App\Models\Device;
use Illuminate\Http\Request;

class CheckDevice {
    public function checkDeviceType ($userAgent, User $user) {        

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
            $userDevice->device_type = $deviceType;
            $userDevice->save();
        }
    }
}