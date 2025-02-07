<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Flight;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ReferralActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnalyticsUserController extends Controller
{
     /// move this to analytics controller once that has been sorted
    public function totalFlight (Request $request){
        try {
            
            $user = $request->user();

            $flightsCount = Flight::where('peace_id', $user->peace_id)
                ->where('passenger_name', $user->user_name)->count();

            return response()->json([
                'error' => false,
                'total_flight_count' => $flightsCount
            ]);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    
    public function totalReferral(Request $request) {
        try  {
            $user = $request->user();

            $referralTable = ReferralActivity::where('referrer_peace_id', $user->peace_id)->get();
            $referrer_count = ReferralActivity::where('referrer_peace_id', $user->peace_id)->count();

            $totalPointEarned = ReferralActivity::where('referrer_peace_id', $user->peace_id)->sum('referrer_points_earned');

            $referredUsers = User::whereHas('referralActivitiesAsReferrer', function ($query) use ($user) {
                    $query->where('referrer_peace_id', $user->peace_id); // Filtering by referrer's peace_id
                })->get();

           
            return response()->json([
                'error' => false,
                'referrer_count' => $referrer_count,
                'total_point_earned' => $totalPointEarned,
                'referralTable' => $referralTable,
                'referred_users' => $referredUsers
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  

    }

    public function countriesVisited(Request $request) {
        try {

            $user = $request->user();

            $numberOfCountriesVisited = Flight::where('peace_id', $user->peace_id)->distinct('destination')->count();

            return response()->json([
                "error" => false,
                "number_of_countries_visted" => $numberOfCountriesVisited
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }


    public function totalMileFlown(Request $request) {
        try {
            $user = $request->user();

            $totalFlightDistance = Flight::where('peace_id', $user->peace_id)
                ->sum('flight_distance');

            return response()->json([
                "error" => false,
                "total_flight_distance" => $totalFlightDistance
            ]);

        }  catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function countriesAndCityChart(Request $request) {
        $user = $request->user();
        $year = Carbon::now()->year;

        try {

            $userTickets = Transaction::where('peace_id', $user->peace_id)
                ->whereYear('created_at', $year)
                ->where('ticket_type', 'ticket')
                ->select(DB::raw('MONTHNAME(created_at) as month_name'), DB::raw('COUNT(*) as total_count'))
                ->groupBy(DB::raw('month_name'))
                ->get();
            
            $organisedUserTickets = $this->organiseYearlyChart($userTickets);
    
            return response()->json([
                "error" => false,
                "user_tickets" => $organisedUserTickets
            ], 200);
        
        }  catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
        
    }

    protected function organiseYearlyChart($userTickets) {
        $yearly = [
            "January" => ["name" => "January", "total_count" => 0],
            "Febuary" => ["name" => "Febuary", "total_count" => 0],
            "March" => ["name" => "March", "total_count" => 0],
            "April" => ["name" => "April", "total_count" => 0],
            "May" => ["name" => "May", "total_count" => 0],
            "June" => ["name" => "June", "total_count" => 0],
            "July" => ["name" => "July", "total_count" => 0],
            "August" => ["name" => "August", "total_count" => 0],
            "September" => ["name" => "September", "total_count" => 0],
            "October" => ["name" => "October", "total_count" => 0],
            "November" => ["name" => "November", "total_count" => 0],
            "December" => ["name" => "December", "total_count" => 0]
        ];

        foreach($userTickets as $item) {
            if($item["month_name"]) {
                $yearly[$item["month_name"]]["total_count"] = $item["total_count"];
            }
        }

        return array_values($yearly);


    }

    public function tripHistory(Request $request) {
        $user = $request->user();

        try {
            $tripHistory = Flight::where('departure_time', '<=', Carbon::now()->toIso8601String())
                ->where('peace_id', $user->peace_id)
                // ->where('is_paid', true)
                ->get();
    
            return response()->json([
                "error" => false,
                "trip_history" => $tripHistory
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function guestTripHistory(Request $request) {
        $user = $request->user();

        try {

            if ($user) {
                $tripHistory = Flight::where('departure_time', '<=', Carbon::now()->toIso8601String())
                    ->where('peace_id', $user->peace_id)
                    // ->where('is_paid', true)
                    ->get();
            } else {
                $guestToken = $request->session()->get('guest_session_token');

               $tripHistory = Flight::where('departure_time', '<=', Carbon::now()->toIso8601String())
                ->where('guest_session_token', $guestToken)
                // ->where('is_paid', true)
                ->get();
            }
    
            return response()->json([
                "error" => false,
                "trip_history" => $tripHistory
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function upcomingTrips(Request $request) {
        $user = $request->user();

        try {

            // get the unpaid upcoming trip where the payment time has not expired
            $unPaidUpcomingTrips = Flight::where('peace_id', $user->peace_id)
                // ->where('is_paid', false)
                ->where('payment_expires_at', '<', Carbon::now()->toIso8601String())
                ->get();

            //get the paid upcoming trip using departure time    
            $paidUpcomingTrips = Flight::where('peace_id', $user->peace_id)
                // ->where('is_paid', true)
                ->where('departure_time', '>', Carbon::now()->toIso8601String())
                ->get();
            
            // $upComingTrip = $unPaidUpcomingTrip->merge($paidUpcomingTrip);
          

            
    
            return response()->json([
                "error" => false,
                "upcoming_trip" => $paidUpcomingTrips,
                "upcoming_trip_unpaid" => $unPaidUpcomingTrips
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function guestUpcomingTrips(Request $request) {
        $user = $request->user();

        try {

            // get the unpaid upcoming trip where the payment time has not expired
            if ($user) {
                $unPaidUpcomingTrip = Flight::where('peace_id', $user->peace_id)
                    // ->where('is_paid', false)
                    ->where('payment_expires_at', '<', Carbon::now()->toIso8601String())
                    ->get();
    
                //get the paid upcoming trip using departure time    
                $paidUpcomingTrip = Flight::where('peace_id', $user->peace_id)
                    // ->where('is_paid', true)
                    ->where('departure_time', '>', Carbon::now()->toIso8601String())
                    ->get();
                
                $upComingTrip = $unPaidUpcomingTrip->merge($paidUpcomingTrip);

            } else {
                // $guestToken = $request->session()->get('guest_session_token');
                $guestToken = $request->input('guest_session_token');
                // dd($guestToken);

                $unPaidUpcomingTrip = Flight::where('guest_session_token', $guestToken)
                    // ->where('is_paid', false)
                    ->where('payment_expires_at', '<', Carbon::now()->toIso8601String())
                    ->get();
    
                //get the paid upcoming trip using departure time    
                $paidUpcomingTrip = Flight::where('guest_session_token', $guestToken)
                    // ->where('is_paid', true)
                    ->where('departure_time', '>', Carbon::now()->toIso8601String())
                    ->get();
                
                $upComingTrip = $unPaidUpcomingTrip->merge($paidUpcomingTrip);
            }

            
    
            return response()->json([
                "error" => false,
                "upcoming_trip" => $upComingTrip
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    // public function deleteFlight() {
    //     $Flight = Flight::find(135);
    //     $Flight->delete();

    //     response()->json([
    //         'error' => false,
    //         'message' => 'flight deleted successfully'
    //     ]);
    // }
}
