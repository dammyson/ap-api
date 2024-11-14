<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\FlightRecord;
use Illuminate\Http\Request;
use App\Events\AdminSurveyEvent;
use App\Events\AdminCustomerEvent;
use Illuminate\Support\Facades\DB;
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

    public function revenueCustomerChart(Request $request, User $user) {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $week = Carbon::now()->week;
        
        $flightRecord = FlightRecord::where('peace_id', $user->peace_id)
            ->whereYear($year)
            ->whereMonth($month)
            ->whereWeek($week)
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();

        dd($flightRecord);


    }


    protected function organiseChart($items) {
        $daysOfWeek = [
            "Monday" => 0,
            "Tuesday" => 0,
            "Wednesday" => 0,
            "Thursday" => 0,
            "Friday" => 0,
            "Saturday" => 0,
            "Sunday" => 0

        ];

        $data = [];
        foreach(array_keys($daysOfWeek) as $dayOfWeek) {
            if(!isset($items[$dayOfWeek])) {
                $data[] = [ "day_name"  => $dayOfWeek, "total_amount" => 0];
            } else {
                $data[] = ["day_name" => $dayOfWeek, "total_amount" => 0];
            }

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
