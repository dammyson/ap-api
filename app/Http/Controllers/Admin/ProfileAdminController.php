<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function editAdminProfile(Request $request) {
        $admin = $request->user('admin');

        try {
           

           $admin->user_name = $request->user_name ?? $admin->user_name;
           $admin->email = $request->email ?? $admin->email;
           $admin->role = $request->role ?? $admin->role;

           if ($request->file('image_url')) {
            // store the file in the admin-profile-images folder
                $path = $request->file('image_url')->store('admin-profile-images');
                // store the path to the image
                $admin->image_url = $path;
           }

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
}
