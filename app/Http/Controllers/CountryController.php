<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    //
    public function storeCountry(Request $request) {
        $request->validate([
            'name' => 'required|string'
        ]);

        try {
            $country = Country::create([
                'name' => $request->input('name')
            ]);

            return response()->json([
                'error' => 'false',
                'country' => $country
            ], 201);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ], 500);
        }

    }

    public function indexCountry() {
        try {
            $countries = Country::all();

            return response()->json([
                'error' => 'false',
                'country' => $countries
            ]);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ]); 
        }

    }
}
