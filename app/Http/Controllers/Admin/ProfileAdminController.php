<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileAdminController extends Controller
{
    public function getAdminProfile(Request $request) {
        $admin = $request->user('admin');

        try {
           

            return response()->json([
                'error' => false,
                'admin_data' => $admin
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
        //    $admin->last_name = $request->last_name ?? $admin->last_name;
           $admin->email = $request->email ?? $admin->email;
           $admin->role = $request->role ?? $admin->role;
           $admin->image_url = $request->image_url ?? $admin->image_url;

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
