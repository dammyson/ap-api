<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ChangeProfileImageRequest;

class ProfileAdminController extends Controller
{
    public function getAdminProfile(Request $request) {
        
        try {
            // get the image url link from the stored name
            $admin = $request->user('admin');

            $admin = Admin::withTrashed()->find($admin->id);

            if ($admin->trashed()) {
                return response()->json([
                    "error" => true,
                    "message" => "not_permitted"
                ], 500);
            }

            $image_url = $admin->image_url;
            $image_url_link = Storage::url($image_url);


            $admin_data = [
                "id" => $admin->id,
                "user_name" => $admin->user_name,
                'email' => $admin->email,
                'role' => $admin->role,
                'phone_number' => $admin->phone_number,
                'image_url_link' => $image_url_link
           ];

            return response()->json([
                'error' => false,
                'admin_data' => $admin_data
            ]);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }    

    }

    // public function changeAdminProfileImage(ChangeProfileImageRequest $request) {
    public function changeAdminProfileImage(Request $request) {
        $admin = $request->user('admin');
        
        try {
            if ($request->file('image_url')) {
                // store the file in the admin-profile-images folder
                    $path = $request->file('image_url')->store('admin-profile-images');
                    // store the path to the image
                    $admin->image_url = $path;

                    $imageUrlLink = Storage::url($path);

                    $admin->save();

                    return response()->json([
                        "error" => false,
                        "message" => "Profile picture updated successfully",
                        "image_url_link" => $imageUrlLink
                    ], 200);
               }
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
        

    }

    public function editAdminProfile(Request $request) {
        $admin = $request->user('admin');

        try {
           

           $admin->user_name = $request->user_name ?? $admin->user_name;
           $admin->email = $request->email ?? $admin->email;
           $admin->phone_number = $request->phone_number ?? $admin->phone_number;

          

           $admin->save();

           return response()->json([
                'error' => false,
                'message' => 'admin data updated successfully',
                'admin' => $admin 
           ]);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function changeAdminRole(Request $request) {
       

        try {

            Gate::authorize('is-admin');

            $email = $request->input('email');
            $newRole = $request->input('new_role');

            $admin = Admin::where('email', $email)->first();
            $admin->role = $newRole;
            $admin->save();
    
            return response()->json([
                "error" => false,
                "message" => "Admin role successfully updated"
            ], 200);
        
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }


    public function deleteAdmin(Request $request) {
        $email = $request->input('email');

        try {

            Gate::authorize('is-admin');

            // if ($request->user('admin')->role !== "Admin") {
            //     return response()->json([
            //         "error" => true,
            //         "message" => "You do not have permission to view team members.
            //             Please contact your system administrator if you believe this is an error"
            //     ], 403);
    
            // }
    
            $admin = Admin::where('email', $email)->first();

            if ($admin) {
                $admin->delete();

            } else {
                response()->json([
                    "error" => true,
                    "message" => "Admin account does not exist"
                ], 400); 
            }
            
            return response()->json([
                "error" => false,
                "message" => "Admin account deleted successfully"
            ], 200);
        
        }catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function deactivateAdminAccount(Request $request) {
        $email = $request->input('email');

        try {

            Gate::authorize('is-admin');

            // if ($request->user('admin')->role !== "Admin") {
            //     return response()->json([
            //         "error" => true,
            //         "message" => "You do not have permission to view team members.
            //             Please contact your system administrator if you believe this is an error"
            //     ], 403);
    
            // }
    
            $admin = Admin::where('email', $email)->first();
            $admin->is_deactivated = true;
            $admin->save();
            
            return response()->json([
                "error" => false,
                "message" => "Admin account deleted successfully"
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
