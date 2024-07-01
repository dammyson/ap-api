<?php
namespace App\Http\Controllers;

use App\Models\GamePlay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamePlayController extends Controller
{
    public function index()
    {
        return response()->json(GamePlay::with('game', 'user')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'user_id' => 'required|exists:users,id',
            'score' => 'required|integer',
            'played_at' => 'required|date',
        ]);

        $gamePlay = GamePlay::create($validated);

        return response()->json($gamePlay, 201);
    }

    public function show(GamePlay $gamePlay)
    {
        return response()->json($gamePlay->load('game', 'user'));
    }

    public function update(Request $request, GamePlay $gamePlay)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'user_id' => 'required|exists:users,id',
            'score' => 'required|integer',
            'played_at' => 'required|date',
        ]);

        $gamePlay->update($validated);

        return response()->json($gamePlay);
    }

    public function destroy(GamePlay $gamePlay)
    {
        $gamePlay->delete();

        return response()->json(null, 204);
    }


        public function gameLeaderboard($gameId)
        {
            $leaderboard = GamePlay::select('user_id', DB::raw('SUM(score) as total_score'))
                ->where('game_id', $gameId)
                ->groupBy('user_id')
                ->orderBy('total_score', 'desc')
                ->with('user') // Assuming you have a relationship with the User model
                ->get();
    
            return response()->json($leaderboard);
        }
    
        public function overallLeaderboard()
        {
            $leaderboard = GamePlay::select('user_id', DB::raw('SUM(score) as total_score'))
                ->groupBy('user_id')
                ->orderBy('total_score', 'desc')
                ->with('user') // Assuming you have a relationship with the User model
                ->get();
    
            return response()->json($leaderboard);
        }
}


