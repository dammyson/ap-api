<?php

namespace App\Http\Controllers;

use App\Models\RedeemedReward;
use Illuminate\Http\Request;

class RedeemedRewardController extends Controller
{
    public function index()
    {
        return response()->json(RedeemedReward::with('reward', 'user')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reward_id' => 'required|exists:rewards,id',
            'user_id' => 'required|exists:users,id',
            'redeemed_at' => 'required|date',
        ]);

        $redeemedReward = RedeemedReward::create($validated);

        return response()->json($redeemedReward, 201);
    }

    public function show(RedeemedReward $redeemedReward)
    {
        return response()->json($redeemedReward->load('reward', 'user'));
    }

    public function update(Request $request, RedeemedReward $redeemedReward)
    {
        $validated = $request->validate([
            'reward_id' => 'required|exists:rewards,id',
            'user_id' => 'required|exists:users,id',
            'redeemed_at' => 'required|date',
        ]);

        $redeemedReward->update($validated);

        return response()->json($redeemedReward);
    }

    public function destroy(RedeemedReward $redeemedReward)
    {
        $redeemedReward->delete();

        return response()->json(null, 204);
    }
}
