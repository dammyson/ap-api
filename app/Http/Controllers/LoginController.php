<?php

namespace App\Http\Controllers;

use App\Models\Tier;
use App\Models\User;
use App\Models\Device;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ScreenResolution;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Notifications\LoginNotification;
use App\Services\Point\TierPointService;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Models\TermsAndCondition;
use App\Services\AutoGenerate\GenerateRandom;
use App\Services\TermsAndConditions\StoreUserTermsAndConditions;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
   
    protected $tierService;

    public function __construct(TierPointService $tierService)
    {
        $this->tierService = $tierService;
    }
    //
    public function login(UserLoginRequest $request)
    {
        try {

            $deviceType = $request->input('device_type');
            $screenResolution = $request->input('screen_resolution');           
            
            $credentials = $request->only('email', 'password');

            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 401);
            }

            $user = User::where('email', $request->email)
                ->first();
            
            if (!$user) {
                return response()->json(['error' => true, 'message' => 'User not found'], 401);
            }

            if ($request->has('firebase_token')) {
                $user->firebase_token = $request->firebase_token;
                $user->save();
            }

            $this->setDeviceAndScreenResolution($user, $deviceType, $screenResolution);
            $this->setLastLoginAndSendNotification($user);

            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ];
            
            return response()->json([
                'error' => false,
                'message' => 'Login successful',
                'data' => $data
            ]);
            
           
        } catch (\Throwable $th) {       
            
           Log::error('LOGIN ERROR', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);
    
            return response()->json([
                "error" => true,            
                "message" => "Something went wrong"
            ], 500);
            
        }
    }

    public function googleVerify(Request $request)
    {    
        try {    
           
            $deviceType = $request->input('device_type');
            $screenResolution = $request->input('screen_resolution');
            
            
            $user = User::where('email', $request->email)->first();
            if (!$user) {

                $request->validate(
                    [
                        'accepted_terms_and_conditions' => 'accepted',
                        'terms_id' => 'required|exists:terms_and_conditions,id'
                    ],
                    [
                        'accepted_terms_and_conditions.accepted' => 'Terms and conditions must be accepted.',
                        'terms_id.required' => 'Terms and conditions are required.',
                        'terms_id.exists' => 'The selected terms and conditions are invalid.',
                    ]
                );

                
               

                $user = DB::transaction(function () use ($request, $deviceType, $screenResolution) {
                    $peace_id = (new GenerateRandom())->generateUniquePeaceId();
                
                    $tier = Tier::where('rank', 1)->first();
                    

                    $user = User::create([
                        'first_name' => $request->input('first_name'),
                        'last_name' => $request->input('last_name'),
                        'email' => $request->input('email'),
                        'phone_number' => "000000000",
                        'peace_id' => $peace_id,
                        // 'peace_id' => $peace_id,
                        'password' => Hash::make(Str::random(16)),
                        // 'status' => $request->input('status') ?? null,
                        'status' => 'active',
                        'device_type' => $deviceType,
                        'points' => 50, // allocate appropriate pointts once decided
                        "firebase_token" => $request->firebase_token,
                        'tier_id' => $tier->id,
                        'last_login' => now()->setTimezone('Africa/Lagos')
                    ]);

               

                    (new StoreUserTermsAndConditions())->run(
                        [
                            'user_id' => $user->id,
                            'terms_id' => $request->terms_id,
                            'accepted_at' => now(),
                            'ip_address' => $request->ip(),
                            'user_agent' => $request->userAgent()
                        ]
                    );

                    return $user;

                });

            }

            
            // Log the user in if they already exist
            $token = auth('api')->login($user);

            $data['token'] = $token;
            $data['user'] = $user;
        
            
            $this->setDeviceAndScreenResolution($user, $deviceType, $screenResolution);
            $this->setLastLoginAndSendNotification($user);
        

            return response()->json([
                'error' => false,
                'message' => 'Login Successful',
                'data' => $data
            ], 200);

        } catch (ValidationException $e) {

            return response()->json([
                'error' => true,
                'message' => $e->validator->errors()->first(),
                'errors' => $e->validator->errors(),
            ], 422);

        } 
        catch (\Throwable $th) {

            Log::error('GOOGLE SIGNUP FAILED', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'Unable to complete login at the moment. Please try again.',
                'actual_message' => $th->getMessage()
            ], 500);
        }
    }          
    
    private function setDeviceAndScreenResolution(User $user, $deviceType = null, $screenResolution = null) {
        if ($deviceType) {
            $userDevice = Device::where('user_id', $user->id)->first();
            $user->device_type = $deviceType;
            $user->save();

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

        if ($screenResolution) {
            $userScreenResolution = ScreenResolution::where('user_id', $user->id)->first();

            if (!$userScreenResolution) {
                ScreenResolution::create([
                    'user_id' => $user->id,
                    'screen_resolution' => $screenResolution
                ]);
            } else {
                $userScreenResolution->screen_resolution = $screenResolution;
                $userScreenResolution->save();
            }
        }
       
    }
          
    
    private function setLastLoginAndSendNotification(User $user) {
        $user->last_login = now()->setTimezone('Africa/Lagos');
        $user->status = 'active';
        $user->save();

        if (!$user->is_guest) {
            $details = [
                'title' => 'New Message',
                'body' => 'You have received a new message.',
                'url' => '/messages/1'
            ];

            $currentTier = $user->currentTier();

            if (!$currentTier) {
                $this->tierService->assignTierWithDefaultFallback($user->id);
            }   
            
            $user->notify(new LoginNotification($details));
        }
       
    }

    public function logout()
    {
        if (!auth()->check()) {
            return response()->json([
                'status' => false,
                'message' => 'No authenticated user found'
            ], 401);
        }
    
        $user = auth()->user();
    
        try {
            $user->update(['status' => 'inactive']);
            $user->token()->revoke();
    
            return response()->json([
                'status' => true,
                'message' => 'User logged out'
            ], 200);
    
        } catch (\Throwable $throwable) {
            // Rollback status update only if it was modified
            if ($user->status === 'inactive') {
                $user->update(['status' => 'active']);
            }
    
            return response()->json([
                'status' => false,
                'message' => 'Failed to log user out'
            ], 500);
        }
    }
}
