<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerAdminController extends Controller
{
    public function customerInformation(Request $request) {
        try {
            $user = $request->user();

            if (!$user->is_admin) { 
                return response()->json([
                    'error' => true,
                    'message' => 'unauthorized'
                ], 400);
            }

            $users = User::where('is_admin', false);

        }  catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'error' => false,
            'users_table_data' => $users
        ]);
    }

    public function activityLog(Request $request) {
        $user = $request->user();

        try {
            if (!$user->is_admin) { 
                return response()->json([
                    'error' => true,
                    'message' => 'unauthorized'
                ], 400);
            } 
            
            $adminUser = User::where('is_admin', true);
        
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
        return response()->json([
            'error' => false,
            'admin_table_data' => $adminUser
        ]);
    }
}
