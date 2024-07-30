<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperAdmin\StoreCityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    //
    public function storeCity(StoreCityRequest $request) {

        try {
            $city = City::create([
                'name' => $request->name,
                'country_id' => $request->country_id
            ]);
    
            return response()->json([
                'error' => 'false',
                'city' => $city
            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
               'error' => 'true',
               'message' =>  $throwable->getMessage()
            ], 500);
        }

    }

    public function indexCity() {
        try {
            $cities = City::all();

            return response()->json([
                'error' => 'false',
                'plane' => $cities
            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ], 500); 
        }

    }
}
