<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Services\AutoGenerate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Services\AutoGenerate\GenerateRandom;
use App\Http\Requests\Auth\Admin\LoginAdminRequest;
use App\Notifications\TemporaryPassword;

class RegisterAdminController extends Controller
{
    public $generateRandom;

    public function __construct(GenerateRandom $generateRandom) {
        $this->generateRandom = $generateRandom;
    }
    
    public function registerAdmin(CreateAdminRequest $request) {
        try {
            // $admin = $request->user('admin');
            
            Gate::authorize('is-admin');            
    
            // generate temporary password
            $username = $request->input('user_name');
            $email = $request->input('email');
            $role = $request->input('role');
            
            $temporaryPassword = $this->generateRandom->generateTemporaryPassword();
            // dump($temporaryPassword);
            $admin = Admin::withTrashed()->where('email', $email)->first();
            
            if ($admin) {
                if ($admin->trashed()) {
                    // dd("I ran");
                    $admin->restore();
                    $admin->password = Hash::make($temporaryPassword);
                    $admin->save();
                } else {
                    return response()->json([
                        "error" => true,
                        "message" => "email already taken"
                    ], 400);
                }
            } else {

                $admin = new Admin();
                
                $admin = Admin::create([
                    'user_name' => $username, 
                    'email' => $email, 
                    'password' => Hash::make($temporaryPassword), 
                    'role' => $role
                ]);
            }

            
            $admin->notify(new TemporaryPassword($temporaryPassword));

           
            // Optionally, generate a token for the newly registered admin
            $data['admin'] =  $admin;
            // $data['token'] = $admin->createToken('AdminToken')->accessToken;
          
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong",
                "actual_message" => $th->getMessage()
            ], 500);
        }  

        return response()->json(['error' => false, 
            'message' => 'Client registration successful. Verification code sent to your email.',
            'data' => $data
        ], 201);

    }

    public function loginAdmin(LoginAdminRequest $request) {
        // Retrieve the admin using the email
        $admin = Admin::where('email', $request->email)->first();

        // Check if the admin exists and if the password is correct
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Generate a Passport token for the admin
            $token = $admin->createToken('AdminToken')->accessToken;
            return response()->json(['token' => $token], 200);
        }
    }
   

    public function logoutAdmin(Request $request)
    {
        try {
            $request->user('admin')->token()->revoke();
           
            return response()->json([
                'error' => false,
                'message' => 'Successfully logged out'
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    
}
