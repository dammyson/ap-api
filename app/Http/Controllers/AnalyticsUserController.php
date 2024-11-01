<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlightRecord;
use App\Models\ReferralActivity;
use App\Models\User;

class AnalyticsUserController extends Controller
{
     /// move this to analytics controller once that has been sorted
    public function totalFlight (Request $request){
        try {
            
            $user = $request->user();

            $flightsCount = FlightRecord::where('peace_id', $user->peace_id)
                ->where('passenger_name', $user->user_name)->count();

            return response()->json([
                'error' => false,
                'total_flight_count' => $flightsCount
            ]);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    }

    
    public function totalReferral(Request $request) {
        try  {
            $user = $request->user();

            $referrer_count = ReferralActivity::where('referrer_peace_id', $user->peace_id)->count();

            $totalPointEarned = ReferralActivity::where('referrer_peace_id', $user->peace_id)->sum('referrer_points_earned');

            $referredUsers = User::whereHas('referralActivitiesAsReferrer', function ($query) use ($user) {
                    $query->where('referrer_peace_id', $user->peace_id); // Filtering by referrer's peace_id
                })->get();

           
            return response()->json([
                'error' => false,
                'referrer_count' => $referrer_count,
                'total_point_earned' => $totalPointEarned,
                'referred_users' => $referredUsers
            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }

    }

    public function countriesVisited(Request $request) {
        try {

            $user = $request->user();

            $numberOfCountriesVisited = FlightRecord::where('peace_id', $user->peace_id)->distinct('destination')->count();

            return response()->json([
                "error" => false,
                "number_of_countries_visted" => $numberOfCountriesVisited
            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    }

    public function totalMileFlown(Request $request) {
        try {
            $user = $request->user();

            $totalFlightDistance = FlightRecord::where('peace_id', $user->peace_id)
                ->sum('distance');

            return response()->json([
                "error" => false,
                "total_flight_distance" => $totalFlightDistance
            ]);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    }
}
