<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Device;
use App\Models\Ticket;
use App\Models\Revenue;
use App\Models\FlightRecord;
use Illuminate\Http\Request;
use App\Models\FlightTicketType;
use App\Models\ScreenResolution;
use App\Models\TransactionRecord;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class DashboardAdminController extends Controller
{
    public function weeklyAnalysis()
    {
        // Get the current date and date of 7 days ago
        $currentDate = Carbon::now();
        $date7DaysAgo = Carbon::now()->subDays(7);
        $date14DaysAgo= Carbon::now()->subDays(14);

        // Query the number of users registered in the last 7 days
        $userCountLast7Days = User::whereBetween('created_at', [$date7DaysAgo, $currentDate])->count();

        // Query the number of users registered in the 7 days before the last 7 days        
        $userCount14Ago = User::whereBetween('created_at', [$date14DaysAgo, $date7DaysAgo])->count();

        // Calculate the percentage change
        if ($userCount14Ago > 0) {
            $percentageChange = (($userCountLast7Days - $userCount14Ago) / $userCount14Ago) * 100;
        } else {
            $percentageChange = $userCountLast7Days > 0 ? 100 : 0; // Handle edge cases
        
        }

        // purchased-ticket
        $ticket7DaysAgo = FlightRecord::whereBetween('created_at', [$date7DaysAgo, $currentDate])->count();
        $ticket14DaysAgo = FlightRecord::whereBetween('created_at', [$date14DaysAgo, $date7DaysAgo])->count();

        if ($ticket14DaysAgo > 0) {
            $percentageChange = (($ticket7DaysAgo - $ticket14DaysAgo) / $ticket14DaysAgo ) * 100;

        }  else {
            $percentageChange = $ticket7DaysAgo > 0 ? 100 : 0; // Handle edge cases
        }

        // total-revenue

        $total7daysRevenue = TransactionRecord::whereBetween('created_at', [$date7DaysAgo, $currentDate])->sum('amount');
        $total14daysRevenue = TransactionRecord::whereBetween('created_at', [$date14DaysAgo, $date7DaysAgo])->sum('amount');


        if ($total14daysRevenue > 0) { 
            $percentageChange = (($total7daysRevenue - $total14daysRevenue) / $total14daysRevenue) * 100;

        } else {
            $percentageChange = $total7daysRevenue > 0 ? 100 : 0; // Handle edge cases
        }

        return response()->json([
            "error" => false,
            "total_registered_users" => [
                "total_registered_users_last_seven_days" => $userCountLast7Days,
                "percentage" => round($percentageChange, 2)
            ],

            "total_purchased_ticket" => [
                'ticket7DaysAgo' => $ticket7DaysAgo,
                'percentageChange' => round($percentageChange, 2)               
            ],
            
            "total_revenue" => [
                'total7daysRevenue' => $total7daysRevenue,
                'percentageChange' => round($percentageChange, 2)
            ]

        ]);
    }

    public function revenueGraph(Request $request, $filter) {
        try {
            $year = $request->input('year') ?? Carbon::now()->year;
            $month = $request->input('month') ?? Carbon::now()->month;
            if ($filter == "yearly") {

                $ticketRecord = TransactionRecord::where('ticket_type', 'ticket')
                    ->whereYear('created_at', $year)
                    ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
                    ->groupBy(DB::raw('month_name'))
                    ->get();
                

                $ticketAmount =  TransactionRecord::where('ticket_type', 'ticket')
                        ->whereYear('created_at', $year)
                        ->sum(DB::raw('CAST(amount AS SIGNED)'));

                $ancillaryRecord = TransactionRecord::where('ticket_type', 'Ancillary')
                    ->whereYear('created_at', $year)
                    ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
                    ->groupBy(DB::raw('month_name'))
                    ->get();
                

                $ancillaryAmount = TransactionRecord::where('ticket_type', 'Ancillary')
                        ->whereYear('created_at', $year)                    
                        ->sum(DB::raw('CAST(amount AS SIGNED)'));
                
                $revenueRecord =  TransactionRecord::whereYear('created_at', $year)
                    ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('SUM(CAST(amount AS SIGNED)) as total_amount'))
                    ->groupBy(DB::raw('month_name'))
                    ->get();

                $revenueAmount = TransactionRecord::whereYear('created_at', $year)                    
                    ->sum(DB::raw('CAST(amount AS SIGNED)'));

                $ticketRecord = $this->organiseYear($ticketRecord);
                $ancillaryRecord = $this->organiseYear($ancillaryRecord);
                $ticketRecord = $this->organiseYear($revenueRecord);
    
                
    
            }
            else {
                
                $year = $request->input('year') ?? Carbon::now()->year;
                $month = $request->input('month') ?? Carbon::now()->month;
                // Define the current week's start and end dates
                $startOfWeek = Carbon::now()->startOfWeek(); // Typically Monday
                $endOfWeek = Carbon::now()->endOfWeek();     // Typically Sunday


                $ticketRecord = TransactionRecord::where('ticket_type', 'ticket')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(CAST(amount as SIGNED)) as total_amount'))
                    ->groupBy('day_name')
                    ->get();
                
                $ticketAmount = TransactionRecord::where('ticket_type', 'ticket')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum(DB::raw('CAST(amount AS SIGNED)'));  
                

                $ticketRecord = $this->organiseWeek($ticketRecord);               

                $ancillaryRecord = TransactionRecord::where('ticket_type', 'Ancillary')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(CAST(amount as SIGNED)) as total_amount'))
                    ->groupBy('day_name')
                    ->get();


                $ancillaryAmount = TransactionRecord::where('ticket_type', 'Ancillary')
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->sum(DB::raw('CAST(amount AS SIGNED)'));

                $ancillaryRecord = $this->organiseWeek($ancillaryRecord);

                $revenueRecord = TransactionRecord::whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->select(DB::raw('DAYNAME(created_at) as day_name'), DB::raw('SUM(CAST(amount as SIGNED)) as total_amount'))
                    ->groupBy('day_name')
                    ->get();

                $revenueRecord = $this->organiseWeek($revenueRecord);
                
                $revenueAmount = TransactionRecord::whereYear('created_at', $year)
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


    public function ticketViaApp(Request $request) {
        $filter = $request->input('filter');
        $data = [];
        if ($filter == "yearly") {
            $transactionRecords = TransactionRecord::where('ticket_type', 'ticket')
                ->select(DB::raw('YEAR(created_at) as year'), DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
                ->groupBy(DB::raw('YEAR(created_at'), DB::raw('MONTH(created_at'))
                ->get();
            
            foreach($transactionRecords as $transactionRecord) {
                if(!isset($data[$transactionRecord->year])) {
                    $data[$transactionRecord->year] = [];
                }

                $data[$transactionRecord->year]['months'][$transactionRecord->month] = $transactionRecord->count;
            }

        }

        if ($filter == "monthly") {
            $transactionRecords = TransactionRecord::where('ticket_type', 'ticket')
                ->where(DB::raw('YEAR(created_at)'), carbon::create(now())->year)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('WEEK(created_at) as week'), DB::raw('COUNT(*) as count'))
                ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('WEEK(created_at)'))
                ->get();

            foreach($transactionRecords as $transactionRecord) {
                if(!isset($transactionRecord[$transactionRecord->month]['weekly'][$transactionRecord->week])) {
                    $transactionRecord[$transactionRecord->month]['weekly'][$transactionRecord->week] = [];
                }

                $transactionRecord[$transactionRecord->month]['weekly'][$transactionRecord->week][] = $transactionRecord->count();
            }
        }

        if ($filter == "weekly") {
            $transactionRecords = TransactionRecord::where('ticket_type', 'ticket')
                ->where(DB::raw('YEAR(created_at)'), carbon::create(now())->year)
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('WEEK(created_at) as week'), DB::raw('DAY(created_at) as day'))
                ->groupBy(DB::raw('MONTH(created_at)'), DB::raw('WEEK(created_at)', DB::raw('DAY(created_at)')))
                ->get();

            foreach($transactionRecords as $transactionRecord) {
                if(!isset($data[$transactionRecord->month])) {
                    $data[$transactionRecord->month] = [];

                }

                $data[$transactionRecord->month]['weeks'][$transactionRecord->week]['days'][$transactionRecord->day] = $transactionRecord->count;


            }
        }
      

        return response()->json([
            'error' => false,
            'tickets' => $data
        ], 200);

    }


    public function userByDevice(Request $request) {
        try {
            // $today = Carbon::now();
            $sevenDaysAgo = Carbon::now()->subDays(7);

            $androidUsers = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'ANDROID')->count();
            $iosUsers = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'IOS')->count();
            $otherUsers = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'UNKNOWN')->count();

            $percentageOfAndroid = $androidUsers > 0 ? ($androidUsers / ($androidUsers + $iosUsers + $otherUsers)) * 100 : 0;
            $percentageOfIos = $iosUsers > 0 ? ($iosUsers / ($androidUsers + $iosUsers + $otherUsers)) * 100 : 0;
            $percentageOfOthers = $iosUsers > 0 ? ($iosUsers / ($androidUsers + $iosUsers + $otherUsers)) * 100 : 0;

            $amountAndroid = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'ANDROID')->sum('amount');
            $amountIos = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'IOS')->sum('amount');
            $amountUnknown = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'UNKNOWN')->sum('amount');

            return response()->json([
                "error" => false,
                "android_percent" => $percentageOfAndroid,
                "ios_percent" => $percentageOfIos,
                "android_revenue" => $amountAndroid,
                "ios_revenue" => $amountIos,
                
            ], 200);

        } catch(\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
        
    }

    public function screenResolution(Request $request) {

        $screenResolutions = ScreenResolution::select('screen_resolution', DB::raw('count(*) as count'))
            ->groupBy('screen_resolution')
            ->get();

        $screenResolutions = $screenResolutions->map(function($screenResolution) {
            return [
                "screen_resolution" => $screenResolution->screen_resolution,
                "count" => $screenResolution->count,
                "percentage" => round((($screenResolution->count / User::count()) * 100), 2),
            ];        
        });

        return response()->json([
            'error' => false,
            'users_and_screenResolution' => $screenResolutions
        ]);
        
    }

    public function totalRegisteredUsersTable(Request $request) {
        try {
            // $users = User::withCount('flightRecords as total_booked_flight')->get();
            $users = User::get();
               
            return new UserCollection($users);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'error' => false,
            'total_registered_users' => $totalRegisteredUsers
        ], 200);
    }

    public function totalPurchasedTicketTable(Request $request) {
        try {
            $ticketPurchased = TransactionRecord::with('user')->get();
            
            // $ticketPurchased = TransactionRecord::with(['user' => function ($query) {
            //     $query->select('id', 'first_name', 'last_name', 'email');
            // }])->get();

            // $tickets = Ticket::with(['flight_ticket_types', 'users']);

        }  catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'error' => false,
            'tickets_info' => $ticketPurchased
        ]);
    }

    public function activeUserTable(Request $request) {
        dd("unimplemented");
    }
}
