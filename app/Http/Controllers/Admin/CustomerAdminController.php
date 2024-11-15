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
use App\Models\TransactionRecord;

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
        // $week = Carbon::now()->week;
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $totalRevenue = TransactionRecord::whereYear('created_at', $year)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();

        $totalRevenueAmount = TransactionRecord::whereYear('created_at', $year)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');
        
        $flightBooking = TransactionRecord::whereYear('created_at', $year)
            ->where('ticket_type', 'ticket')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();
        
        $flightBookingAmount = TransactionRecord::whereYear('created_at', $year)
            ->where('ticket_type', 'ticket')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');    
            
        $appPurchase = TransactionRecord::whereYear('created_at', $year)
            ->where('ticket_type', 'Ancillary')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();
        
        $appPurchaseAmount = TransactionRecord::whereYear('created_at', $year)
            ->where('ticket_type', 'Ancillary')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount'); 

        $totalRevenue = $this->organiseChart($totalRevenue);
        $flightBooking = $this->organiseChart($flightBooking);
        $appPurchase = $this->organiseChart($appPurchase);
        
        return response()->json([
            "error" => false,
            "total_flight_amount" => $flightBookingAmount,
            "flight_booking" => $flightBooking,
            "app_purchase_amount" => $appPurchaseAmount,
            "app_purchase" => $appPurchase,
            "total_revenue_amount" => $totalRevenueAmount,
            "total_revenue" => $totalRevenue

        ], 200);


    }


    protected function organiseChart($items) {
        $daysOfWeek = [
            "Monday" => ["name" => "Monday", "total_amount" => 0],
            "Tuesday" => ["name" => "Tuesday", "total_amount" => 0],
            "Wednesday" => ["name" => "Wednesday", "total_amount" => 0],
            "Thursday" => ["name" => "Thursday", "total_amount" => 0],
            "Friday" => ["name" => "Friday", "total_amount" => 0],
            "Saturday" => ["name" => "Saturday", "total_amount" => 0],
            "Sunday" => ["name" => "Sunday", "total_amount" => 0]

        ];

        $data = [];
        // foreach(array_keys($daysOfWeek) as $dayOfWeek) {
        //     if(!isset($items[$dayOfWeek])) {
        //         $data[] = [ "day_name"  => $dayOfWeek, "total_amount" => 0];
        //     } else {
        //         $data[] = ["day_name" => $dayOfWeek, "total_amount" => 0];
        //     }

        // }
   
        foreach($items as $item) {
            $dayName = $item->day_name;
            $daysOfWeek[$dayName]["total_amount"] = $item->total_amount;
        }

        return array_values($daysOfWeek);
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
