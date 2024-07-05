<?php

namespace App\Http\Controllers;

use App\Http\Requests\Game\StoreGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        return response()->json(Game::with('category')->get());
    }

    public function store(StoreGameRequest $request)
    {
        $game = Game::create($request->validated());

        return response()->json($game, 201);
    }

    public function show(Game $game)
    {
        return response()->json($game->load('category', 'rules', 'gamePlays'));
    }

    public function update(UpdateGameRequest $request, Game $game)
    {

        $game->update($request->validated());

        return response()->json($game);
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json(null, 204);
    }
}
