<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Models\ReferralActivity;
use App\Models\User;
use App\Services\AutoGenerate\CreatePeaceId;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    //
    public $createPeaceId;

    public function __construct(CreatePeaceId $createPeaceId)
    {
        $this->createPeaceId = $createPeaceId;
    }
    
    public function userRegister(CreateUserRequest $request)
    {

        try {
            // $peace_id =  $this->createPeaceId->generateUniquePeaceId();
            $points = 50;
           
            $create = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'peace_id' => $request->input('peace_id'),
                'password' => Hash::make($request->input('password')),
                'status' => $request->input('status') ?? null,
                'points' => 50, // allocate appropriate pointts once decided
            
            ]);

            $referrer_peace_id = $request->input('referrer_peace_id');
            
            if ($referrer_peace_id) {
                $referrer_points_earned = 20;
                $referrer = User::where('peace_id', $referrer_peace_id)->first();
                // dd($referrer);
                if ($referrer) {
                    $referrer->points += $referrer_points_earned;
                    $referrer->save();

                    $referee = $create;
                    
                    $referrer_user_name = $referrer->first_name . ' '. $referrer->last_name;
                    $referee_user_name = $referee->first_name . ' '. $referee->last_name;

    
                    ReferralActivity::create([
                        "referrer_peace_id" => $referrer_peace_id,
                        "referrer_user_name" => $referrer_user_name,
                        "referrer_points_earned" => $referrer_points_earned,
                        "referee_peace_id" => $referee->peace_id,
                        "referee_user_name" => $referee_user_name,
                        
                    ]);

                }            
            }

           
           
          
        } catch (\Exception $exception) {
            return response()->json(['error' => true, 'message' => $exception->getMessage()], 500);
        }

        $data['user'] =  $create;
        $data['token'] =  $create->createToken('Nova')->accessToken;

        return response()->json(['error' => false, 'message' => 'Client registration successful. Verification code sent to your email.', 'data' => $data], 201);

    }

    public function changePassword(ChangePasswordRequest $request) {

        try {
            
            $user = User::where('email', $request->input("email"))->first();
            
            if (!$user) {
                    return response()->json([
                            "error" => "true",
                            "message" => "user not found"
                        ], 404);
                    }
    
            if (!Hash::check($request->input("current_password"), $user->password)) {
                return response()->json(['error' => true, 'message' => 'Invalid password'], 500);
            }
    
            $user->password =  Hash::make($request->input("new_password"));
            $user->save();
    
            return response()->json(['error' => false, 'message' => 'password updated successfully', 'user' => $user], 200);
           

        } catch (\Throwable $throwable) {
            return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
        }

    }

    protected function sendMail($to_name, $to_email, $otp) {
         $data = ['name' => $to_name, 'body' => 'Airpeace Otp', 'otp' => $otp];

         Mail::send('sendmail', $data, 
         function($message) use($to_name, $to_email) {
             $message->to($to_email, $to_name);
             $message->subject('Reset Password mail');
             // This line below might not be necessary as they are 
             // already configured from our config/mail.php script
             $message->from('Ocelot Group', 'Mail to reset password');
         }

     );
    }

    protected function generateOtp() {
        $otp = '';
        for ($i=0; $i < 4; $i++) {
           $num = rand(0, 9);
           $otp .= $num;
        }

        return (int)$otp;

    }


    public function forgotPassword(ForgotPasswordRequest $request) {

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

    public function verifyOtp(VerifyOtpRequest $request) {

        try {
            
            $user = User::where('email', $request->input('email'))->firstOrFail();

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

    public function resetPassword(ResetPasswordRequest $request) {
        try {
             
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                    return response()->json([
                            "error" => "true",
                            "message" => "user not found"
                        ], 404);
                    }
    
            if (!$user->can_change_password) {
                return response()->json(['error' => true, 'message' => 'please verify otp first'], 500);
    
            }
    
    
            $user->password =  $request->input("new_password");
            $user->save();
    
            return response()->json(['error' => false, 'message' => 'password updated successfully', 'user' => $user], 200);
           

        } catch (\Throwable $throwable) {
            return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
        }

    }

    public function logoutUser(Request $request)
    {
        try {
            $request->user()->token()->revoke();
           
            return response()->json([
                'error' => false,
                'message' => 'Successfully logged out'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);

        }
    }


}
