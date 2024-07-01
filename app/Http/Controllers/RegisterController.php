<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    //
    public function clientRegister(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|numeric|digits:11',
            'password' => 'required|string|min:4|max:4|confirmed',
            'peace_id' => 'required|numeric'
        ]);

        try {
            $create = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'password' => Hash::make($request->input('password')),
                'peace_id' => $request->input('peace_id')
            ]);

            // Generate a random verification code
            // $verificationCode = $this->generateVerificationCode();

            // Send verification email
            // $this->sendVerificationCode($create->email, $verificationCode);
        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }

        $data['user'] =  $create;
        $data['token'] =  $create->createToken('Nova')->accessToken;
        // $data['token_plainText'] = $data['token']->plainTextToken;

        return response()->json(['error' => false, 'message' => 'Client registration successful. Verification code sent to your email.', 'data' => $data], 201);

    }

    protected function sendMail($to_name, $to_email, $otp) {
        //  $data = ['name' => $to_name, 'body' => 'Airpeace Otp', 'otp' => $otp];

        //  Mail::send('sendmail', $data, 
        //  function($message) use($to_name, $to_email) {
        //      $message->to($to_email, $to_name);
        //      $message->subject('Reset Password mail');
        //      // This line below might not be necessary as they are 
        //      // already configured from our config/mail.php script
        //      //$message->from('Ocelot Group', 'Mail to reset password');
        //  }

    //  );
    }

    protected function generateOtp() {
        $otp = '';
        for ($i=0; $i < 4; $i++) {
           $num = rand(0, 9);
           $otp .= $num;
        }

        // return (int)$otp;
        return 1111;
    }


    public function forgotPassword(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                "error" => "true",
                "message" => "user not found"
            ], 404);
        }

        $otp = $this->generateOtp();
        $this->sendMail($user->user_name, $user->email, $otp);
        $user->otp = $otp;
        $user->save();

        return response()->json([
            "error" => "false",
            "message" => "otp sent to email successfully"
        ]);
    }

    public function verifyOtp(Request $request) {
        $request->validate([
            'email'=> 'required|email',
            'otp' => 'required|min:4|max:4'
        ]);

        try {
            
            $user = User::where('email', $request->input('email'))->firstOrFail();
            
            // $user = User::where('email', $request->email)->first();

            // if (!$user) {
            //     return response()->json([
            //         "error" => "true",
            //         "message" => "user not found"
            //     ], 404);
            // }

            if ( $user->otp !== $request->otp ) {
                return response()->json([
                    'error' => 'true',
                    "message" => "otp verification failed"
                ]);
            }

            $user->can_change_password = true;
            $user->save();
            
            return response()->json([
                'error' => 'false',
                "message" => "You've been verified",
                "user" => $user
            ]);
        
        } catch (\Throwable $throwable) {
            return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
        
        }

           

    }

    public function resetPassword(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:4|max:4|confirmed',

        ]);

        try {
            
            
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                    return response()->json([
                            "error" => "true",
                            "message" => "user not found"
                        ], 404);
                    }
            // $user = User::where('email', $request->input('email'))->firstOrFail();
    
            if (!$user->can_change_password) {
                return response()->json(['error' => true, 'message' => 'please verify otp first'], 500);
    
            }
    
    
            $user->password =  $validated["new_password"];
            // $user->can_change_password = false;
            $user->save();
    
            return response()->json(['error' => false, 'message' => 'password updated successfully', 'user' => $user], 200);
            // $user::update([
            //     "password" => $validated["new_password"]
            // ]);

        } catch (\Throwable $throwable) {
            return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
        }

    }

    public function changePassword(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'current_password' => 'required',
            'new_password' => 'required|min:4|max:4|confirmed',

        ]);

        try {
            
            
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                    return response()->json([
                            "error" => "true",
                            "message" => "user not found"
                        ], 404);
                    }
            // $user = User::where('email', $request->input('email'))->firstOrFail();
    
            if (!Hash::check($validated["current_password"], $user->password)) {
                return response()->json(['error' => true, 'message' => 'Invalid password'], 500);
            }
    
            $user->password =  $validated["new_password"];
            $user->save();
    
            return response()->json(['error' => false, 'message' => 'password updated successfully', 'user' => $user], 200);
            // $user::update([
            //     "password" => $validated["new_password"]
            // ]);

        } catch (\Throwable $throwable) {
            return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
        }

    }
}
