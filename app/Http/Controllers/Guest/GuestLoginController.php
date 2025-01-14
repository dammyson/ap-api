<?php

namespace App\Http\Controllers\Guest;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuestLoginController extends Controller
{
    public function continueAsGuest(Request $request) {
       $guestToken = Str::uuid(); // Generate a unique token
    
       $request->session()->put('guest_session_token', $guestToken);

        return response()->json(['guest_session_token' => $guestToken]);
    }

}
