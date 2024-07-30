<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuperAdmin\StorePlaneRequest;
use App\Models\Plane;
use Illuminate\Http\Request;

class PlaneController extends Controller
{
    //
    public function storePlane(StorePlaneRequest $request) {

        try {
            $plane = Plane::create([
                'name' => $request->input('name'),
                'code' => $request->input('code'),
                'capacity' => $request->input('capacity')
            ]);

            return response()->json([
                'error' => 'false',
                'plane' => $plane
            ], 201);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ], 500);
        }

    }

    public function indexPlane() {
        try {
            $planes = Plane::all();

            return response()->json([
                'error' => 'false',
                'plane' => $planes
            ], 200);

        } catch (\Throwable $throwable) {
            return response()->json([
                'error' => 'true',
                'message' => $throwable->getMessage()
            ], 500); 
        }

    }
}
