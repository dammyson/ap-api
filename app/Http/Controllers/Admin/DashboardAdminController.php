<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Device;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\FlightTicketType;
use App\Http\Controllers\Controller;
use App\Models\Revenue;
use App\Models\ScreenResolution;

class DashboardAdminController extends Controller
{
    public function totalRegisteredUsers(Request $request) {
        $user = $request->user();

        if (!$user->is_admin) { 
            return response()->json([
                'error' => true,
                'message' => 'unauthorized'
            ], 400);
        }

        $sevenDaysAgo = Carbon::now()->subDays(7);

        $usersCount = User::where('is_admin', false)
            ->where('created_at', '>=', $sevenDaysAgo)
            ->count();

        return response()->json([
            'error' => false,
            'registeredUsersCountLastSevenDays' => $usersCount
        ], 200);
    }

    public function purchasedTicket(Request $request) {
        $user = $request->user();

        if (!$user->is_admin) { 
            return response()->json([
                'error' => true,
                'message' => 'unauthorized'
            ], 400);
        }
        
        $sevenDaysAgo = Carbon::now()->subDays(7);
        
        $ticketsCountSevenDaysAgo = Ticket::where('created_at', '>=', $sevenDaysAgo)->count();

        return response()->json([
            'error' => false,
            'ticketCountLastSevenDays' => $ticketsCountSevenDaysAgo
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

        $sevenDaysAgo = Carbon::now()->subDays(7);

        $totalRevenue = FlightTicketType::where('created_at', '>=', $sevenDaysAgo)->sum('price');

        return response()->json([
            'error' => false,
            'totalRevenueLastSevenDays' => $totalRevenue
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
