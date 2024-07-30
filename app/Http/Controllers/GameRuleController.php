<?php
namespace App\Http\Controllers;

use App\Http\Requests\Game\StoreGameRuleRequest;
use App\Http\Requests\Game\UpdateGameRule;
use App\Models\GameRule;

class GameRuleController extends Controller
{
    public function index()
    {
        return response()->json(GameRule::with('game')->get());
    }

    public function store(StoreGameRuleRequest $request)
    {

        $gameRule = GameRule::create($request->validated());

        return response()->json($gameRule, 201);
    }

    public function show(GameRule $gameRule)
    {
        return response()->json($gameRule->load('game'));
    }

    public function update(UpdateGameRule $request, GameRule $gameRule)
    {

        $gameRule->update($request->validated());

        return response()->json($gameRule);
    }

    public function destroy(GameRule $gameRule)
    {
        $gameRule->delete();

        return response()->json(null, 204);
    }
}
