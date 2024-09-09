<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeAdminPasswordRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAdminController extends Controller
{
    public function changeAdminPassword(ChangeAdminPasswordRequest $request) {

        try {
            $currentPassword = $request->input('current_password');
            $newPassword = $request->input('new_password');

            $admin = $request->user('admin');

            if (!Hash::check($currentPassword, $admin->password)) {
                return response()->json([
                    'error' => true,
                    'message' => 'current password is incorrect'
                ], 500);
            }

            $admin->password = Hash::make($newPassword);
            $admin->save();

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);

        }        
        
        return response()->json([
            'error' => false,
            'message' => 'Your password has been updated. Remember to use the new password on your next log in'

        ], 200);
    }
}
