<?php

namespace App\Http\Controllers;

use App\Http\Requests\Game\StoreGameCategoryRequest;
use App\Http\Requests\Game\UpdateGameCategoryRequest;
use App\Models\GameCategory;
use Illuminate\Support\Facades\Log;

class GameCategoryController extends Controller
{
    public function index()
    {
        try {

            return response()->json(GameCategory::all());
        } catch (\Throwable $th) {

            Log::error('ERROR RETRIEVING GAME CATEGORY', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }

    public function store(StoreGameCategoryRequest $request)
    {
        try {
            
            $gameCategory = GameCategory::create($request->validated());

            return response()->json($gameCategory, 201);

        } catch (\Throwable $th) {

            Log::error('ERROR STORING GAME CATEGORY', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }

    public function show(GameCategory $gameCategory)
    {   
        try {
            
           return response()->json($gameCategory);

        } catch (\Throwable $th) {

            Log::error('ERROR SHOWING GAME CATEGORY BY ID', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
        
        
    }

    public function update(UpdateGameCategoryRequest $request, GameCategory $gameCategory)
    {
        try {
            
            $gameCategory->update($request->validated());

            return response()->json($gameCategory);


        } catch (\Throwable $th) {

            Log::error('ERROR UPDATING GAME CATEGORY', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }

    public function destroy(GameCategory $gameCategory)
    {
        try {
            
            $gameCategory->delete();

            return response()->json(null, 204);

        } catch (\Throwable $th) {

            Log::error('ERROR DELETING GAME CATEGORY BY ID', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }
}

