<?php
namespace App\Http\Controllers;

use App\Http\Requests\Game\StoreGamePlayRequest;
use App\Http\Requests\Game\UpdateGamePlayRequest;
use App\Models\GamePlay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GamePlayController extends Controller
{
    public function index()
    {
        return response()->json(GamePlay::with('game', 'user')->get());
    }

    public function store(StoreGamePlayRequest $request)
    {

        $gamePlay = GamePlay::create($request->validated());

        return response()->json($gamePlay, 201);
    }

    public function show(GamePlay $gamePlay)
    {
        return response()->json($gamePlay->load('game', 'user'));
    }

    public function update(UpdateGamePlayRequest $request, GamePlay $gamePlay)
    {

        $gamePlay->update($request->validated());

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


