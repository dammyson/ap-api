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
    public function getWeeklyUserRegistrationAnalysis()
    {
        // Get the current date and date of 7 days ago
        $currentDate = Carbon::now();
        $startDate = Carbon::now()->subDays(7);

        // Query the number of users registered in the last 7 days
        $userCountLast7Days = User::whereBetween('created_at', [$startDate, $currentDate])->count();

        // Query the number of users registered in the 7 days before the last 7 days
        $previousStartDate = Carbon::now()->subDays(14);
        $previousEndDate = Carbon::now()->subDays(7);
        $userCountPrevious7Days = User::whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();

        // Calculate the percentage change
        if ($userCountPrevious7Days > 0) {
            $percentageChange = (($userCountLast7Days - $userCountPrevious7Days) / $userCountPrevious7Days) * 100;
        } else {
            $percentageChange = $userCountLast7Days > 0 ? 100 : 0; // Handle edge cases
        }

        // Prepare the result
        $result = [
            'total_users_registered_last_7_days' => $userCountLast7Days,
            'percentage_change_vs_last_7_days' => round($percentageChange, 2) . '%'
        ];

        return response()->json($result);
    }


    public function totalRegisteredUsers(Request $request) {
        $today = Carbon::now();
        $lastSevenDays = Carbon::now()->subDays(7);
        $userCountLast7Days = User::whereBetween('created_at', [$today, $lastSevenDays])->count();
        

        $lastFourteenDays = Carbon::now()->subDays(14)->endOfDay();
        $totalRegisteredUsersLastFourteenDays = User::whereBetween('created_at', [$lastSevenDays, $lastFourteenDays])->count();


        if ($totalRegisteredUsersLastFourteenDays > 0) {
            $percentageChange = (($userCountLast7Days -  $totalRegisteredUsersLastFourteenDays )/ $totalRegisteredUsersLastFourteenDays) * 100; 

        }  else {
            $percentageChange = $userCountLast7Days > 0 ? 100 : 0; // Handle edge cases
        }


        return response()->json([
            "error" => false,
            "total_registered_users_last_seven_days" => $userCountLast7Days,
            "percentage" => $percentageChange
        ]);
    
    }

    public function purchasedTicket(Request $request) {
        $user = $request->user();

        if (!$user->is_admin) { 
            return response()->json([
                'error' => true,
                'message' => 'unauthorized'
            ], 400);
        }
        
        $today = Carbon::now();
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $fourteenDaysAgo = Carbon::now()->subDays(14);


        $ticket7DaysAgo = FlightRecord::whereBetween('created_at', [$sevenDaysAgo, $today])->count();
        $ticket14DaysAgo = FlightRecord::whereBetween('created_at', [$sevenDaysAgo, $fourteenDaysAgo])->count();

        $percentageChange = (($ticket7DaysAgo - $ticket14DaysAgo) / $ticket14DaysAgo ) * 100;
        // $ticketsCountSevenDaysAgo = Ticket::where('created_at', '>=', $sevenDaysAgo)->count();

        return response()->json([
            'error' => false,
            'ticket7DaysAgo' => $ticket7DaysAgo,
            'percentageChange' => $percentageChange,
            'ticketCountLastSevenDays' => $ticket7DaysAgo,

        ], 200);
    }

    public function totalRevenue(Request $request) {
        $user = $request->user();

        if (!$user->is_admin) { 
            return response()->json([
                'error' => true,
                'message' => 'unauthorized'
            ], 400);
        }

        $today = Carbon::now();
        $sevenDaysAgo = Carbon::now()->subDays(7)->endOfDay();
        $fourteenDaysAgo = Carbon::now()->subDays(14)->endOfDay();
        // $totalRevenue = FlightTicketType::where('created_at', '>=', $sevenDaysAgo)->sum('price');

        $total7daysRevenue = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, $today])->count();
        $total14daysRevenue = TransactionRecord::whereBetween('created_at', [$fourteenDaysAgo, $sevenDaysAgo])->count();


        $percentageChange = (($total7daysRevenue - $total14daysRevenue) / $total14daysRevenue) * 100;

        return response()->json([
            'error' => false,
            'totalRevenueLastSevenDays' => $total7daysRevenue,
            'percentageChange' => $percentageChange
        ], 200);
    }

    public function ticketViaApp(Request $request) {
        $tickets = TransactionRecord::where('ticket_type', 'ticket')->get();
        $Ancillary = TransactionRecord::where('ticket_type', 'Ancillary')->get();

        $totalRevenue = TransactionRecord::get();

        return response()->json([
            'error' => false,
            'tickets' => $tickets
        ], 200);

    }

    public function ancillaryViaApp(Request $request) {
        $Ancillary = TransactionRecord::where('ticket_type', 'Ancillary')->get();


        return response()->json([
            'error' => false,
            'ancillary_tickets' => $Ancillary
        ], 200);
    }

    public function totalRevenueViaApp(Request $request) {
        $totalRevenue = TransactionRecord::get();

        return response()->json([
            'error' => false,
            'total_revenue' => $totalRevenue
        ], 200);
    }


    public function userByDeviceTwo(Request $request) {
        try {
            // $today = Carbon::now();
            $sevenDaysAgo = Carbon::now()->subDays(7);

            $androidUsers = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'Android')->count();
            $iosUsers = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'IOS')->count();

            $percentageOfAndroid = $androidUsers > 0 ? ($androidUsers / ($androidUsers + $iosUsers)) * 100 : 0;
            $percentageOfIos = $iosUsers > 0 ? ($iosUsers / ($androidUsers + $iosUsers)) * 100 : 0;

            $amountAndroid = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'Android')->sum('amount');
            $amountIos = TransactionRecord::whereBetween('created_at', [$sevenDaysAgo, now()])->where('device_type', 'IOS')->sum('amount');

            return response()->json([
                "error" => false,
                "android_percent" => $percentageOfAndroid,
                "ios_percent" => $percentageOfIos,
                "android_revenue" => $amountAndroid,
                "ios_revenue" => $amountIos
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
            $users = User::withCount('flightRecords as total_booked_flight')->get();
               
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
            $user = $request->user();

            if (!$user->is_admin) { 
                return response()->json([
                    'error' => true,
                    'message' => 'unauthorized'
                ], 400);
            }

            $tickets = Ticket::with(['flight_ticket_types', 'users']);

        }  catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'error' => false,
            'tickets_info' => $tickets
        ]);
    }

    public function activeUserTable(Request $request) {
        dd("unimplemented");
    }
}
