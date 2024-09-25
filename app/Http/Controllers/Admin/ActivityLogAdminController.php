<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogAdminController extends Controller
{
    public function storeActivityLog(Request $request) {
        $activity_type = $request->input('activity_type');
        $description = $request->input('description');
   
        $admin = $request->user('admin');

        try{
            $activityLog =  ActivityLog::create([
                'admin_id' => $admin->id,
                'role' => $admin->role,
                'activity_type' => $activity_type,
                'description' => $description,
                'ip_address' => request()->ip()
            ]);

        } catch(\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
       

        return response()->json([
            'error' => false,
            'activityLog' => $activityLog
        ], 200);
    }

    public function indexActivityLog() {
        try {         

            $activityLogs = ActivityLog::with(['admin' => function($query) {
                $query->select('id', 'user_name', 'role');
            }])->get();

        } catch(\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
       

        return response()->json([
            'error' => false,
            'activityLog' => $activityLogs
        ], 200);
    }
}
