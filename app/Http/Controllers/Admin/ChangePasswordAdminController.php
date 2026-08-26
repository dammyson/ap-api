<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\ChangeAdminPasswordRequest;

class ChangePasswordAdminController extends Controller
{
    public function changeAdminPassword(ChangeAdminPasswordRequest $request) {

        try {
            $currentPassword = $request->input('current_password');
            $newPassword = $request->input('new_password');
            $newPasswordConfirmation = $request->input("new_password_confirmation");

            $admin = $request->user('admin');

            if ($newPassword != $newPasswordConfirmation) {
                return response()->json([
                    'error' => true,
                    'message' => 'new password and new password confirmation does not match'
                ], 500); 
            }

            if (!Hash::check($currentPassword, $admin->password)) {
                return response()->json([
                    'error' => true,
                    'message' => 'current password is incorrect'
                ], 500);
            }

            $admin->password = Hash::make($newPassword);
            $admin->save();

            return response()->json([
                'error' => false,
                'message' => 'Your password has been updated. Remember to use the new password on your next log in'

            ], 200);

        } catch (\Throwable $th) {

            Log::error('ERROR CHANGING ADMIN PASSWORD', [
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
