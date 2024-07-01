<?php

namespace App\Http\Controllers;

use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    public function index()
    {
        return response()->json(GameCategory::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $gameCategory = GameCategory::create($validated);

        return response()->json($gameCategory, 201);
    }

    public function show(GameCategory $gameCategory)
    {
        return response()->json($gameCategory);
    }

    public function update(Request $request, GameCategory $gameCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $gameCategory->update($validated);

        return response()->json($gameCategory);
    }

    public function destroy(GameCategory $gameCategory)
    {
        $gameCategory->delete();

        return response()->json(null, 204);
    }
}

