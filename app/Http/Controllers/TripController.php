<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\SpecialDeal;
use App\Models\ExcitingCity;
use App\Models\FeaturedTrip;
use App\Models\FlightRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\FavoriteCityEvent;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function featuredTrip(Request $request) {
        // $image_url = $request->input('image_url');
        // $is_bookmark = $request->input('is_bookmark');
        // $rating = $request->input('rating');
        // $countryName = $request->input('country_name');

        try {

            $user = $request->user();
    
            $featuredTrip = FeaturedTrip::where('peace_id', $user->peace_id)->get();
            
            return response()->json([
                'error' => false,
                'featured_trip' => $featuredTrip
            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    }

    public function specialDeals(Request $request) {
        // $image_url = $request->input('image_url');
        // $is_bookmark = $request->input('is_bookmark');
        // $oldPrice = $request->input('old_price');
        // $newPrice = $request->input('new_price');
        // $country = $request->input('country');

        try {

            $specialDeal = SpecialDeal::get();

            return response()->json([
                'error' => false,
                'special_deal' => $specialDeal
            ]);
        
        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }

    }

    public function favoriteCitiesEvent(Request $request) {
        $image_url = $request->input('image_url');
        $is_bookmark = $request->input('is_bookmark');
        $title = $request->input('title');
        $city = $request->input('city');
        $country = $request->input('country');
        $date = $request->input('date');

        $user = $request->user();

        try {
            $flightCities = FlightRecord::where('user_id', $user->id)
                ->groupBy('destination')->take(5)->get();
    
            $favoriteCitiesEvents = [];
            foreach ($flightCities as $flightCity) {
                $cityEvents = FavoriteCityEvent::where("city", $flightCity)->get();
                $favoriteCitiesEvent[] = $cityEvents;
            }

            return response()->json([
                'error' => false,
                'flightCitiesEvents' => $favoriteCitiesEvent
            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }

    }

    public function travelPattern(Request $request) {
        try {
            $user = $request->user();
            
            $totalFlightCount = FlightRecord::where('peace_id', $user->peace_id)->count();

            // $flightRecord = FlightRecord::where('peace_id', $user->peace_id)
            //     ->groupBy('destination')->sortBy('desc')->select('destination')->take(7)->get();
    
            // $totalFlightCount = $totalFlightRecord->count();

            $destinations = FlightRecord::where('peace_id', $user->peace_id)
                ->select('destination', DB::raw('count(*) as count'))                
                ->groupBy('destination')->get()
                ->map(function($destination) use($totalFlightCount) {
                $destination->percentage = $totalFlightCount > 0 ? round(((($destination->count)/ $totalFlightCount) * 100), 2) : 0;
                return $destination;
            });
            
                       
            return response()->json([
                'error' => false,
                // 'flightRecord' => $flightRecord,
                // 'total_flight_count' => $totalFlightCount,
                'destinations' => $destinations
            ], 200);
            
        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    
    }

    public function busiestMonth(Request $request) {
        // $startMonth = Carbon::startOfMonth();
        // $endMonth = Carbon::endOfMonth()->endOfDay;
        $startMonth = '';
        $endMonth = '';

        try {
            $user = $request->user();

            $flightRecords = FlightRecord::where('peace_id', $user->peace_id)                                
                ->select(DB::raw('YEAR(departure_time) as year'), DB::raw('MONTH(departure_time) as month', DB::raw('COUNT(*) as count')))
                ->groupBy(DB::raw('YEAR(departure_time)'), DB::raw('MONTH(departure_time)'))
                ->orderBy(DB::raw('YEAR(departure_time)'))
                ->orderBy(DB::raw('MONTH(departure_time'))
                ->get();
            
            $data = [];
            foreach($flightRecords as $flightRecord) {
                $year = $flightRecord->year;
                $month = Carbon::create($flightRecord->month)->format('F');

                if (!isset($data[$year])) {
                    $data[$year]['labels'] = [];
                    $data[$month]['counts'] = []; 
                }

                $data[$year]['labels'][] = $month;
                $data[$year]['counts'][] = $flightRecord->count;

            }
                
    
            return response()->json([
                'error' => false,
                'flight_record' => $data
                // 'busy_month_chart_data' => $busyMonthChartData
            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    }

    public function listCountries(Request $request) {
        $user = $request->user();

        try {
            $listOfCountries = FlightRecord::where('peace_id', $user->peace_id)->select('arrival', 'destination')->get();
            
            return response()->json([
                'error' => false,
                'list_of_countries' => $listOfCountries

            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    }

    

    public function checkoutCities(Request $request) {

        try {
            $imageUrl = $request->input('image_url');
            $countryName = $request->input('countryName');
            $description = $request->input('description');

            $excitingCity = ExcitingCity::get();

            return response()->json([
                'error' => false,
                'excitingCity' => $excitingCity

            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => true,
                'message' => $throwable->getMessage()
            ], 500); 
        }
    }
}
