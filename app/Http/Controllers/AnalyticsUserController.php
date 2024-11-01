<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlightRecord;
use App\Models\ReferralActivity;

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

            return response()->json([
                'error' => false,
                'referrer_count' => $referrer_count
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

            FlightRecord::where('peace_id', $user->peace_id)
                ->when('distance', function($query) {
                    
                });

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    }
}
