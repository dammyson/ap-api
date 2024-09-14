<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Admin\VerifyAdminOtpRequest;
use App\Http\Requests\Admin\ResetAdminPasswordRequest;

class ForgetPasswordAdminController extends Controller
{

   public function forgotPassword(ForgotPasswordRequest $request) {

       $admin = Admin::where('email', $request->email)->first();

       if (!$admin) {
           return response()->json([
               "error" => "true",
               "message" => "pls enter correct email"
           ], 404);
       }

       // generateOtp
       $otp = random_int(1000, 9999);
       
        try {
            Mail::to($admin->email)->send(new ForgotPassword($admin->user_name, $otp));
        
        } catch (\Exception $e) {
            return response()->json([
                "error" => true,
                "message" => "Failed to send OTP email. Please try again."
            ], 500);
        }

        $admin->otp_expires_at = Carbon::now()->addMinutes(10); 

        $admin->otp = $otp;

        $admin->save();

        return response()->json([
            "error" => "false",
            "message" => "otp sent to email successfully",
           
        ], 200);
   }

   public function verifyOtp(VerifyAdminOtpRequest $request) {

       try {
           
           $admin = Admin::where('email', $request->input('email'))->firstOrFail();

           // convert the string into a carbon type so you can validate it with isPast method
           $otp_expiration = Carbon::parse($admin->otp_expires_at);
           
           // Check if OTP is correct and hasn't expired
            if ($admin->otp !== $request->otp || $otp_expiration->isPast()) {
                return response()->json([
                    'error' => true,
                    "message" => "OTP verification failed."
                ], 400);
            }

        
           
           return response()->json([
               'error' => 'false',
               "message" => "You've been verified",
               "user" => $admin
           ], 200);
       
       } catch (\Throwable $throwable) {
           return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
       
       }   

   }

   public function resetPassword(ResetAdminPasswordRequest $request) {
       try {
            
           $admin = Admin::where('email', $request->email)->first();

           
           if (!$admin) {
                return response()->json([
                    "error" => "true",
                    "message" => "admin not found"
                ], 404);
            }

            $otp_expiration = Carbon::parse($admin->otp_expires_at);

            if ($admin->otp !== $request->otp || $otp_expiration->isPast()) {
                return response()->json([
                    'error' => 'true',
                    "message" => "otp does not match or has expired"
                ]);
            }
    
           $admin->password =  Hash::make($request->input("new_password"));
           
           // make otp field and otp_expires_at null, so it cannot be reused
           $admin->otp = null;
           $admin->otp_expires_at = null;
           $admin->save();


   
           return response()->json(['error' => false, 'message' => 'password updated successfully', 'user' => $admin], 200);
          

        } catch (\Throwable $throwable) {
            return response()->json(['error' => true, "message" => $throwable->getMessage()], 500);
        }

   }
}
