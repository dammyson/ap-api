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
use App\Http\Controllers\Controller;

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
        $lastSevenDays = Carbon::now()->subDays(7)->endOfDay();
        $userCountLast7Days = User::whereBetween('created_at', [$today, $lastSevenDays])->count();
        

        $lastFourteenDays = Carbon::now()->subDays(14)->endOfDay();
        $totalRegisteredUsersLastFourteenDays = User::whereBetween('created_at', [$lastSevenDays, $lastFourteenDays])->count();


        if ($totalRegisteredUsersLastFourteenDays > 0) {
            $percentChange = (($userCountLast7Days -  $totalRegisteredUsersLastFourteenDays )/ $totalRegisteredUsersLastFourteenDays) * 100; 

        }  else {
            $percentageChange = $userCountLast7Days > 0 ? 100 : 0; // Handle edge cases
        }


        return response()->json([
            "error" => false,
            "total_registered_users_last_seven_days" => $userCountLast7Days,
            "percentage" => $percentChange
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
            'totalRevenueLastSevenDays' => $total7daysRevenue
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

    public function userByDevice(Request $request) {
        $user = $request->user();

        if (!$user->is_admin) { 
            return response()->json([
                'error' => true,
                'message' => 'unauthorized'
            ], 400);
        }

        $sevenDaysAgo = Carbon::now()->subDays(7);
    
        // Count and total amount for Android devices
        $androidDeviceCount = Device::where('device_type', 'Android')
            ->whereHas('revenues', function($query) use ($sevenDaysAgo) {
                $query->where('created_at', '>=', $sevenDaysAgo);
            })
            ->count();
        
        $androidTotalRevenue = Revenue::whereHas('device', function($query) {
                $query->where('device_type', 'Android');
            })
            ->where('created_at', '>=', $sevenDaysAgo)
            ->sum('amount');

        // Count and total amount for iOS devices
        $iosDeviceCount = Device::where('device_type', 'IOS')
            ->whereHas('revenues', function($query) use ($sevenDaysAgo) {
                $query->where('created_at', '>=', $sevenDaysAgo);
            })
            ->count();
        
        $iosTotalAmount = Revenue::whereHas('device', function($query) {
                $query->where('device_type', 'IOS');
            })
            ->where('created_at', '>=', $sevenDaysAgo)
            ->sum('amount');


        return response()->json([
            'error' => false,
            'android_device_count' => $androidDeviceCount,
            'android_device_revenue' => $androidTotalRevenue,
            'ios_device_count' => $iosDeviceCount,
            'iosTotalAmount' => $iosTotalAmount
        ], 200);
    }

    public function screenResolution(Request $request) {
        $user = $request->user();

        if (!$user->is_admin) { 
            return response()->json([
                'error' => true,
                'message' => 'unauthorized'
            ], 400);
        }

        $screenResolution = ScreenResolution::all();

        return response()->json([
            'error' => false,
            'users_and_screenResolution' => $screenResolution
        ]);
        
    }

    public function totalRegisteredUsersTable(Request $request) {
        try {
            $user = $request->user();

            if (!$user->is_admin) { 
                return response()->json([
                    'error' => true,
                    'message' => 'unauthorized'
                ], 400);
            }

            $totalRegisteredUsers = User::where('is_admin', false);
               

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
