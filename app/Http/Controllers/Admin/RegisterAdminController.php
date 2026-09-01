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
use Illuminate\Support\Facades\DB;

class RegisterAdminController extends Controller
{
    public $generateRandom;

    public function __construct(GenerateRandom $generateRandom) {
        $this->generateRandom = $generateRandom;
    }
    
    public function registerAdmin(CreateAdminRequest $request) {
        try {
            
            Gate::authorize('is-admin');            
    
            // generate temporary password
            $username = $request->input('user_name');
            $email = $request->input('email');
            $role = $request->input('role');
            
            $temporaryPassword = $this->generateRandom->generateTemporaryPassword();
    
            $admin = Admin::withTrashed()->where('email', $email)->first();
            
            $createdAdmin = DB::transaction(function () use ($admin, $temporaryPassword, $username, $email, $role) {
                if ($admin) {
                    if ($admin->trashed()) {
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
                return $admin;
            });

           
            // Optionally, generate a token for the newly registered admin
            $data['admin'] =  $createdAdmin;
            // $data['token'] = $admin->createToken('AdminToken')->accessToken;

            return response()->json(['error' => false, 
                'message' => 'Client registration successful. Verification code sent to your email.',
                'data' => $data
            ], 201);
          
        } catch (\Throwable $th) {

            Log::error('ADMIN ADDING/SIGN UP FAILED', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong',
                'actual_message'=> $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ], 500);
        }

     

    }

    public function loginAdmin(LoginAdminRequest $request) {

        try {
            // Retrieve the admin using the email
            $admin = Admin::where('email', $request->email)->first();
    
            // Check if the admin exists and if the password is correct
            if ($admin && Hash::check($request->password, $admin->password)) {
                // Generate a Passport token for the admin
                $token = $admin->createToken('AdminToken')->accessToken;
                return response()->json(['token' => $token], 200);
            }

        } catch (\Throwable $th) {

            Log::error('ADMIN LOGIN ERROR', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
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

            Log::error('ADMIN LOGOUT ERROR', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }

    
}
