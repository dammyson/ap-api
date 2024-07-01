<?php
namespace App\Http\Controllers;

use App\Models\GameRule;
use Illuminate\Http\Request;

class GameRuleController extends Controller
{
    public function index()
    {
        return response()->json(GameRule::with('game')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'rule' => 'required|string',
        ]);

        $gameRule = GameRule::create($validated);

        return response()->json($gameRule, 201);
    }

    public function show(GameRule $gameRule)
    {
        return response()->json($gameRule->load('game'));
    }

    public function update(Request $request, GameRule $gameRule)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'rule' => 'required|string',
        ]);

        $gameRule->update($validated);

        return response()->json($gameRule);
    }

    public function destroy(GameRule $gameRule)
    {
        $gameRule->delete();

        return response()->json(null, 204);
    }
}
