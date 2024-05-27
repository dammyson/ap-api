<?php

namespace App\Http\Controllers;

use App\Models\Plane;
use Illuminate\Http\Request;

class PlaneController extends Controller
{
    //
    public function storePlane(Request $request) {
        $request->validate([
            'name' => 'required|string'
        ]);

        try {
            $plane = Plane::create([
                'name' => $request->input('name')
            ]);

            return response()->json([
                'error' => 'false',
                'plane' => $plane
            ]);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ]);
        }

    }

    public function indexPlane() {
        try {
            $planes = Plane::all();

            return response()->json([
                'error' => 'false',
                'plane' => $planes
            ]);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ]); 
        }

    }
}
