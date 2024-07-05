<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperAdmin\StoreAirportRequest;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function storeAirport(StoreAirportRequest $request) {

        try {
            $airport = Airport::create([
                'city_id' => $request['city_id'],
                'name' => $request['name']
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
        
        return response()->json([
            'error' => false,
            'airport' => $airport
        ], 201);        

    }

    public function indexAirport() {
        try {
            $airports = Airport::all();

        }  catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'error' => false,
            'airport' => $airports
        ], 201);  

    }
}
