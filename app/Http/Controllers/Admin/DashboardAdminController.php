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
            "total_registered-users" => [
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
