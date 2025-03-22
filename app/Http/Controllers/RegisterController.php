<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tier;
use App\Models\User;
use App\Models\Device;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use App\Models\RecentActivity;
use App\Models\ReferralActivity;
use App\Models\ScreenResolution;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Services\Utility\CheckDevice;
use App\Services\Point\TierPointService;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Services\AutoGenerate\CreatePeaceId;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Notifications\SignUpNotification;
use Google\Service\Walletobjects\SignUpInfo;

class RegisterController extends Controller
{
    //
    public $createPeaceId;
    // public $checkDevice;

    protected $tierService;

    public function __construct(CreatePeaceId $createPeaceId, TierPointService $tierService)
    {
        $this->createPeaceId = $createPeaceId;
        // $this->checkDevice = $checkDevice;
        $this->tierService = $tierService;
    }
    
    public function userRegister(CreateUserRequest $request)
    {

        try {
            // $peace_id =  $this->createPeaceId->generateUniquePeaceId();
            $points = 50;
            $deviceType = $request->input('device_type');
            $screenResolution = $request->input('screen_resolution');
            $tier = Tier::where('rank', 1)->first();
           
            $create = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'peace_id' => $request->input('peace_id'),
                // 'peace_id' => $peace_id,
                'password' => Hash::make($request->input('password')),
                // 'status' => $request->input('status') ?? null,
                'status' => 'active',
                'device_type' => $deviceType,
                'points' => 50, // allocate appropriate pointts once decided
                "firebase_token" => $request->firebase_token,
                'tier_id' => $tier->id,
                'last_login' => now()->setTimezone('Africa/Lagos')
            
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

            $currentTier = $create->currentTier();
            if(!$currentTier) {
                $this->tierService->assignTierWithDefaultFallback($create->id);
            }
            
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

            if (!$create->is_guest) {
                $details = [
                    'title' => 'New Message',
                    'body' => 'You have received a new message.',
                    'url' => '/messages/1'
                ];
    
                $create->notify(new SignUpNotification($details));

            }


            // RecentActivity::create([
            //     "title" => "New user registration",
            //     "description" => "{$create->first_name} {$create->last_name} ({$create->email})"
            // ]);

            // $userAgent = $request->header('User-Agent');
                
            // $deviceType = $this->checkDevice->checkDeviceType($userAgent, $create);
            // $screenResolution = $this->checkDevice->saveScreenSize($create, $request->screen_resolution);
          
        } catch (\Exception $e) {       
            
            Log::error($e->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong",
                "message_err" => $e->getMessage()
            ], 500);
            
        }

        $data['user'] =  $create;
        $data['token'] =  $create->createToken('Nova')->accessToken;

        return response()->json([
            'error' => false, 
            'message' => 'Client registration successful. Verification code sent to your email.', 
            'data' => $data,
            // 'device_type' => $deviceType,
            // 'screen_resolution' => $screenResolution
        ], 201);

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
           

        } catch (\Exception $e) {       
            
            Log::error($e->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
            
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
            "error" => false,
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
        
        } catch (\Exception $e) {       
            
            Log::error($e->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
            
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
           

        } catch (\Exception $e) {       
            
            Log::error($e->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
            
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

        } catch (\Exception $e) {       
            
            Log::error($e->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
            
        }
    }


    //// new forget password implementation
    public function forgotPasswordNew(ForgotPasswordRequest $request) {

        $user = User::where('email', $request->email)->first();
 
        if (!$user) {
            return response()->json([
                "error" => true,
                "message" => "pls enter correct email"
            ], 404);
        }
 
        // generateOtp
        $otp = random_int(1000, 9999);
        
         try {
             Mail::to($user->email)->send(new ForgotPassword($user->first_name, $otp));
         
         } catch (\Exception $e) {
             return response()->json([
                 "error" => true,
                 "message" => "Failed to send OTP email. Please try again."
             ], 500);
         }
 
         $user->otp_expires_at = Carbon::now()->addMinutes(10); 
 
         $user->otp = $otp;
 
         $user->save();
 
         return response()->json([
             "error" => false,
             "message" => "otp sent to email successfully",
            
         ], 200);
    }
 
    public function verifyOtpNew(Request $request) {
 
        try {
            
            $user = User::where('email', $request->input('email'))->firstOrFail();
 
            // convert the string into a carbon type so you can validate it with isPast method
            $otp_expiration = Carbon::parse($user->otp_expires_at);
            
            // Check if OTP is correct and hasn't expired
             if ($user->otp !== $request->otp || $otp_expiration->isPast()) {
                 return response()->json([
                     'error' => true,
                     "message" => "OTP verification failed."
                 ], 400);
             }
 
         
            
            return response()->json([
                'error' => false,
                "message" => "You've been verified",
                "user" => $user
            ], 200);
        
        } catch (\Throwable $throwable) {
            return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
        
        }   
 
    }
 
    public function resetPasswordNew(Request $request) {
        try {
             
            $user = User::where('email', $request->email)->first();
 
            
            if (!$user) {
                 return response()->json([
                     "error" => true,
                     "message" => "admin not found"
                 ], 404);
             }
 
             $otp_expiration = Carbon::parse($user->otp_expires_at);
 
             if ($user->otp !== $request->otp || $otp_expiration->isPast()) {
                 return response()->json([
                     'error' => true,
                     "message" => "otp does not match or has expired"
                 ]);
             }
     
            $user->password =  Hash::make($request->input("new_password"));
            
            // make otp field and otp_expires_at null, so it cannot be reused
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save(); 
    
            return response()->json(['error' => false, 'message' => 'password updated successfully', 'user' => $user], 200);
           
 
         } catch (\Throwable $throwable) {
             return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
         }
 
    }

}
