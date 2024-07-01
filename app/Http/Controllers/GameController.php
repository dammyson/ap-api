<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json(Game::with('category')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'game_category_id' => 'required|exists:game_categories,id',
        ]);

        $game = Game::create($validated);

        return response()->json($game, 201);
    }

    public function show(Game $game)
    {
        return response()->json($game->load('category', 'rules', 'gamePlays'));
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'game_category_id' => 'required|exists:game_categories,id',
        ]);

        $game->update($validated);

        return response()->json($game);
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json(null, 204);
    }
}
