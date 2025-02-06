<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\AdminActivityLog;
use App\Http\Requests\CreateFilterActivityRequest;

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

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
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

        }catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
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

        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }

        return response()->json([
            'error' => false,
            'filtered_activity_log' => $filteredActivityLog
        ], 200);
    }

}
