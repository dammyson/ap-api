<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\FlightRecord;
use Illuminate\Http\Request;
use App\Events\AdminSurveyEvent;
use App\Models\ReferralActivity;
use App\Models\TransactionRecord;
use App\Events\AdminCustomerEvent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CustomerCollection;
use App\Models\UserActivityLog;

class CustomerAdminController extends Controller
{
    public function userInformation(Request $request) {
        $user = $request->user();

        $flightCount = TransactionRecord::where('peace_id', $user->peace_id)->
            where('ticket_type', 'ticket')
            ->count();
        //or

        // $flightCount = FlightRecord::where('peace_id', $user->peace_id)->with('invoices', function($query) {
        //         $query->where('is_paid', false);
        //  })
        //  ->distinct('booking_id')->count();

        $refferalCount = ReferralActivity::where('referrer_peace_id', $user->peace_id)->count();

        $dateOfRegistration = $user->created_at;

        $lastFlight = FlightRecord::where('departure_date', '<=', Carbon::now()->toIso8601String())->orderBy('desc')->first();
        $upcomingFlight = FlightRecord::where('departure_date', '>=', Carbon::now()->toIso8601String())->orderBy('asc')->first();

        $userActivityLog = UserActivityLog::where('user_id', $user->id);
        
        return response()->json([
            "user_image_url_link" => Storage::url($user->image_url),
            "user_firstname" => $user->first_name,
            "user_lastname" => $user->last_name,
            "user_phonenumber" => $user->phone_number,
            "user_total_flight_flown" => $flightCount,
            "user_refferal_Count" => $refferalCount,
            "user_date_of_reg" => $dateOfRegistration,
            "last_flight" => $lastFlight,
            "upcoming_flight" => $upcomingFlight


        ]);
    
    }

    public function revenueCustomerChart(Request $request, User $user) {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        // $week = Carbon::now()->week;
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $totalRevenue = TransactionRecord::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();

        $totalRevenueAmount = TransactionRecord::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');
        
        $flightBooking = TransactionRecord::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->where('ticket_type', 'ticket')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();
        
        $flightBookingAmount = TransactionRecord::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->where('ticket_type', 'ticket')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');    
            
        $appPurchase = TransactionRecord::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->where('ticket_type', 'Ancillary')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();
        
        $appPurchaseAmount = TransactionRecord::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
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
                    'error' => false,
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
