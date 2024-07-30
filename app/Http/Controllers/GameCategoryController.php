<?php

namespace App\Http\Controllers;

use App\Http\Requests\Game\StoreGameCategoryRequest;
use App\Http\Requests\Game\UpdateGameCategoryRequest;
use App\Models\GameCategory;

class GameCategoryController extends Controller
{
    public function index()
    {
        return response()->json(GameCategory::all());
    }

    public function store(StoreGameCategoryRequest $request)
    {
        $gameCategory = GameCategory::create($request->validated());

        return response()->json($gameCategory, 201);
    }

    public function show(GameCategory $gameCategory)
    {
        return response()->json($gameCategory);
    }

    public function update(UpdateGameCategoryRequest $request, GameCategory $gameCategory)
    {
       
        $gameCategory->update($request->validated());

        return response()->json($gameCategory);
    }

    public function destroy(GameCategory $gameCategory)
    {
        $gameCategory->delete();

        return response()->json(null, 204);
    }
}

