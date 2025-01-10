<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Admin\ActivityLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFilterActivityRequest;
use App\Models\Admin\AdminActivityLog;

class ActivityLogAdminController extends Controller
{
    public function storeActivityLog(Request $request) {
        $activity_type = $request->input('activity_type');
        $description = $request->input('description');
   
        $admin = $request->user('admin');

        try{
            $activityLog =  AdminActivityLog::create([
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

            $activityLogs = AdminActivityLog::with(['admin' => function($query) {
                $query->withTrashed()->select('id', 'user_name', 'role');
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

    public function filterActivityLog(CreateFilterActivityRequest $request) {
        $startDate = $request->input('start_date');
        $endDate = Carbon::parse($request->input('end_date') ?? now())->endOfDay();

        try {
            $filteredActivityLog = AdminActivityLog::whereBetween('created_at', [$startDate, $endDate])
                ->with(['admin' => function($query) {
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
            'filtered_activity_log' => $filteredActivityLog
        ], 200);
    }

}
