<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeProfileImageRequest;
use Illuminate\Support\Facades\Storage;

class ProfileAdminController extends Controller
{
    public function getAdminProfile(Request $request) {
        $admin = $request->user('admin');

        try {
           // get the image url link from the stored name
           $image_url = $admin->image_url;
           $image_url_link = Storage::url($image_url);

            return response()->json([
                'error' => false,
                'admin_data' => $admin,
                'image_url_link' => $image_url_link
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function changeAdminProfileImage(ChangeProfileImageRequest $request) {
        $admin = $request->user('admin');
        
        try {
            if ($request->file('image_url')) {
                // store the file in the admin-profile-images folder
                    $path = $request->file('image_url')->store('admin-profile-images');
                    // store the path to the image
                    $admin->image_url = $path;

                    $imageUrlLink = Storage::url($path);

                    return response()->json([
                        "error" => false,
                        "message" => "Profile picture updated successfully",
                        "user" => $admin,
                        "image_url_link" => $imageUrlLink
                    ], 200);
               }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
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
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function changeAdminRole(Request $request) {
        $email = $request->input('email');
        $newRole = $request->input('new_role');

        try {
            if ($request->user('admin')->role !== "Admin") {
                return response()->json([
                    "error" => true,
                    "message" => "You do not have permission to view team members.
                        Please contact your system administrator if you believe this is an error"
                ], 403);
    
            }
    
            $admin = Admin::where('email', $email)->first();
            $admin->role = $newRole;
            $admin->save();
    
            return response()->json([
                "error" => false,
                "message" => "Admin role successfully updated"
            ], 200);
        
        } catch(\Throwable $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ], 500); 
        }
    }


    public function deleteAdmin(Request $request) {
        $email = $request->input('email');

        try {
            if ($request->user('admin')->role !== "Admin") {
                return response()->json([
                    "error" => true,
                    "message" => "You do not have permission to view team members.
                        Please contact your system administrator if you believe this is an error"
                ], 403);
    
            }
    
            $admin = Admin::where('email', $email)->first();
            $admin->delete();
            
            return response()->json([
                "error" => false,
                "message" => "Admin account deleted successfully"
            ], 200);
        
        } catch(\Throwable $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ], 500); 
        }
    }
}
