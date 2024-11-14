<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminCustomerEvent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\AdminSurveyEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;

class CustomerAdminController extends Controller
{
    public function customerInformation(Request $request) {
        try {

            $users = User::all();

            $customerCollection = new CustomerCollection($users);

        }  catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'error' => false,
            'users_table_data' => $customerCollection
        ]);
    }

    public function awardPointManually(Request $request, User $user) {
        $admin = $request->user('admin');
        $points = $request->input('points');
        $reason = $request->input('reason');

        try {
                $message = "reason {$reason}";
            
                $user->points += $points;
                $user->save();
            
                event( new AdminCustomerEvent($admin,  $points, $user, $reason));

                return response()->json([
                    'error' => 'false',
                    'points' => $points,
                    'message' => "{$points} points allocated to {$user->first_name} {$user->last_name}"
                ], 200);

        }  catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

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
