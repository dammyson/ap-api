<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Flight;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\UserActivityLog;
use App\Events\AdminSurveyEvent;
use App\Models\ReferralActivity;
use App\Events\AdminCustomerEvent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Services\Utility\OrganiseChart;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CustomerCollection;

class CustomerAdminController extends Controller
{
    public $organiseChart;
    public function __construct(OrganiseChart $organiseChart) {
        $this->organiseChart = $organiseChart;
    }

    public function userInformation(Request $request, User $user) {
        // $user = $request->user();
        $tierInfo = $user->currentTier();
        $flightCount = Transaction::where('peace_id', $user->peace_id)->
            where('ticket_type', 'ticket')
            ->count();
        //or

        // $flightCount = Flight::where('peace_id', $user->peace_id)->with('invoices', function($query) {
        //         $query->where('is_paid', false);
        //  })
        //  ->distinct('booking_id')->count();

        $refferalCount = ReferralActivity::where('referrer_peace_id', $user->peace_id)->count();

        $dateOfRegistration = $user->created_at;

        $lastFlight = Flight::where('departure_time', '<=', Carbon::now()->toIso8601String())->orderBy('departure_time', 'desc')->first();
        $upcomingFlight = Flight::where('departure_time', '>=', Carbon::now()->toIso8601String())->orderBy('departure_time', 'asc')->first();

        $userActivityLog = UserActivityLog::where('user_id', $user->id)->get();
        
        return response()->json([
            "user_image_url_link" => Storage::url($user->image_url),
            "user_firstname" => $user->first_name,
            "user_lastname" => $user->last_name,
            "user_phonenumber" => $user->phone_number,
            "user_total_flight_flown" => $flightCount,
            "user_refferal_Count" => $refferalCount,
            "user_date_of_reg" => $dateOfRegistration,
            "user_point" => $user->points,
            "user_all_time_point" => $user->all_time_point,
            "last_flight" => $lastFlight,
            "upcoming_flight" => $upcomingFlight,
            "user_activity" => $userActivityLog,
            "tier_information" => [
                "user_point" => $user->points,
                "tier_name" => $tierInfo->name,
                "tier_description" => $tierInfo->description,
                "tier_rank" => $tierInfo->rank
            ]


        ]);
    
    }

    public function userRevenueChart(Request $request, User $user, $filter) {
        try {
            $year = $request->input('year') ?? Carbon::now()->year;
            $month = $request->input('month') ?? Carbon::now()->month;
            if ($filter == "yearly") {

                $ticketRecord = Transaction::where('peace_id', $user->peace_id)
                        ->where('ticket_type', 'ticket')
                    ->whereYear('created_at', $year)
                    ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
                    ->groupBy(DB::raw('month_name'))
                    ->get();
                

                $ticketAmount =  Transaction::where('peace_id', $user->peace_id)
                        ->where('ticket_type', 'ticket')
                        ->whereYear('created_at', $year)
                        ->sum(DB::raw('CAST(amount AS SIGNED)'));

                $ancillaryRecord = Transaction::where('peace_id', $user->peace_id)
                    ->where('ticket_type', 'Ancillary')
                    ->whereYear('created_at', $year)
                    ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
                    ->groupBy(DB::raw('month_name'))
                    ->get();
                

                $ancillaryAmount = Transaction::where('peace_id', $user->peace_id)
                    ->where('ticket_type', 'Ancillary')
                    ->whereYear('created_at', $year)                    
                    ->sum(DB::raw('CAST(amount AS SIGNED)'));
                
                $revenueRecord =  Transaction::where('peace_id', $user->peace_id)
                    ->whereYear('created_at', $year)
                    ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
                    ->groupBy(DB::raw('month_name'))
                    ->get();

                $revenueAmount = Transaction::where('peace_id', $user->peace_id)
                    ->whereYear('created_at', $year)                    
                    ->sum(DB::raw('CAST(amount AS SIGNED)'));

                $ticketRecord = $this->organiseYear($ticketRecord);
                $ancillaryRecord = $this->organiseYear($ancillaryRecord);
                $revenueRecord = $this->organiseYear($revenueRecord);

                // $ticketRecord = $this->organiseChart->organiseYear($ticketRecord);
                // $ancillaryRecord = $this->organiseChart->organiseYear($ancillaryRecord);
                // $ticketRecord = $this->organiseChart->organiseYear($revenueRecord);                
    
            }
            else {
                
                $year = $request->input('year') ?? Carbon::now()->year;
                $month = $request->input('month') ?? Carbon::now()->month;
                // Define the current week's start and end dates
                $startOfWeek = Carbon::now()->startOfWeek(); // Typically Monday
                $endOfWeek = Carbon::now()->endOfWeek();     // Typically Sunday


                $ticketRecord = Transaction::where('peace_id', $user->peace_id)
                    ->where('ticket_type', 'ticket')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(CAST(amount as SIGNED)) as total_amount'))
                    ->groupBy('day_name')
                    ->get();
                
                $ticketAmount = Transaction::where('peace_id', $user->peace_id)
                        ->where('ticket_type', 'ticket')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum(DB::raw('CAST(amount AS SIGNED)'));  
                


                $ancillaryRecord = Transaction::where('peace_id', $user->peace_id)
                    ->where('ticket_type', 'Ancillary')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(CAST(amount as SIGNED)) as total_amount'))
                    ->groupBy('day_name')
                    ->get();


                $ancillaryAmount = Transaction::where('peace_id', $user->peace_id)
                    ->where('ticket_type', 'Ancillary')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum(DB::raw('CAST(amount AS SIGNED)'));


                $revenueRecord = Transaction::where('peace_id', $user->peace_id)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(CAST(amount as SIGNED)) as total_amount'))
                    ->groupBy('day_name')
                    ->get();

                $ticketRecord = $this->organiseWeek($ticketRecord);               
                $ancillaryRecord = $this->organiseWeek($ancillaryRecord);
                $revenueRecord = $this->organiseWeek($revenueRecord);

                // $ticketRecord = $this->organiseChart->organiseWeek($ticketRecord);
                // $ancillaryRecord = $this->organiseChart->organiseWeek($ancillaryRecord);
                // $revenueRecord = $this->organiseChart->organiseWeek($revenueRecord);
                
                $revenueAmount = Transaction::where('peace_id', $user->peace_id)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum(DB::raw('CAST(amount AS SIGNED)'));
            }

            return response()->json([
                'error' => false,
                'ticket' => [ 
                    "ticket_data" => $ticketRecord,
                    "ticket_amount" => (int)  $ticketAmount
                ],
                'ancillary' => [
                    "ancillary_data" => $ancillaryRecord,
                    "ancillary_amount" => (int)  $ancillaryAmount
                ], 
                'revenue' => [
                    'revenue_data' => $revenueRecord,
                    'revenue_amount' => (int)  $revenueAmount
                ]
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function revenueCustomerChart(Request $request, User $user) {
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        // $week = Carbon::now()->week;
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $totalRevenue = Transaction::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();

        $totalRevenueAmount = Transaction::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');
        
        $flightBooking = Transaction::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->where('ticket_type', 'ticket')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();
        
        $flightBookingAmount = Transaction::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->where('ticket_type', 'ticket')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount');    
            
        $appPurchase = Transaction::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->where('ticket_type', 'Ancillary')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(amount) as total_amount'))
            ->groupBy('day_name')
            ->get();
        
        $appPurchaseAmount = Transaction::where('peace_id', $user->peace_id)
            ->whereYear('created_at', $year)
            ->where('ticket_type', 'Ancillary')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->sum('amount'); 



        //////////////////////////////////////
        $ticketRecord = Transaction::where('peace_id', $user->peace_id)
                ->where('ticket_type', 'ticket')
            ->whereYear('created_at', $year)
            ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
            ->groupBy(DB::raw('month_name'))
            ->get();
    

        $ticketAmount =  Transaction::where('peace_id', $user->peace_id)
                ->where('ticket_type', 'ticket')
            ->whereYear('created_at', $year)
            ->sum(DB::raw('CAST(amount AS SIGNED)'));

        $ancillaryRecord = Transaction::where('ticket_type', 'Ancillary')
            ->whereYear('created_at', $year)
            ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
            ->groupBy(DB::raw('month_name'))
            ->get();
        

        $ancillaryAmount = Transaction::where('ticket_type', 'Ancillary')
                ->whereYear('created_at', $year)                    
                ->sum(DB::raw('CAST(amount AS SIGNED)'));
        
        $revenueRecord =  Transaction::whereYear('created_at', $year)
            ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
            ->groupBy(DB::raw('month_name'))
            ->get();

        $revenueAmount = Transaction::whereYear('created_at', $year)                    
            ->sum(DB::raw('CAST(amount AS SIGNED)'));

        ///////////////////////////////////


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
        try {

            Gate::authorize('is-admin');

            if (!Gate::allows('is-admin')) {
               return response()->json([
                    "error" => true,
                    "message" => "not authorized to carry out this action"
               ], 403);
            }

            $admin = $request->user('admin');
            $points = $request->input('points');
            $reason = $request->input('reason');

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

    private function organiseWeek($transactionArray) {
        // Define an array for all days of the week with default total_amount as 0
        $daysOfWeek = [
            "Monday" => ["name" => "Monday", "total_amount" => 0],
            "Tuesday" => ["name" => "Tuesday", "total_amount" => 0],
            "Wednesday" => ["name" => "Wednesday", "total_amount" => 0],
            "Thursday" => ["name" => "Thursday", "total_amount" => 0],
            "Friday" => ["name" => "Friday", "total_amount" => 0],
            "Saturday" => ["name" => "Saturday", "total_amount" => 0],
            "Sunday" => ["name" => "Sunday", "total_amount" => 0],
        ];

         // Populate ticket data with query results
        foreach ($transactionArray as $transaction) {
            $dayName = $transaction->day_name;
            $daysOfWeek[$dayName]['total_amount'] = (int) $transaction->total_amount;
        }

        // Convert the daysOfWeek array to a non-associative array for JSON response
        return array_values($daysOfWeek);
        
    } 

    private function organiseYear($transactionArray) {
        // Define an array for all days of the week with default total_amount as 0
        $daysOfWeek = [
            "January" => ["name" => "January", "total_amount" => 0],
            "Febuary" => ["name" => "Febuary", "total_amount" => 0],
            "March" => ["name" => "March", "total_amount" => 0],
            "April" => ["name" => "April", "total_amount" => 0],
            "May" => ["name" => "May", "total_amount" => 0],
            "June" => ["name" => "June", "total_amount" => 0],
            "July" => ["name" => "July", "total_amount" => 0],
            "August" => ["name" => "August", "total_amount" => 0],
            "September" => ["name" => "September", "total_amount" => 0],
            "October" => ["name" => "October", "total_amount" => 0],
            "November" => ["name" => "November", "total_amount" => 0],
            "December" => ["name" => "December", "total_amount" => 0]
        ];

         // Populate ticket data with query results
        foreach ($transactionArray as $transaction) {
            $monthName = $transaction->month_name;
            $daysOfWeek[$monthName]['total_amount'] = (int) $transaction->total_amount;
        }

        // Convert the daysOfWeek array to a non-associative array for JSON response
        return array_values($daysOfWeek);
        
    }
}
