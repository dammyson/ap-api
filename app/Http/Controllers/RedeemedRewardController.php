<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reward\StoreRedeemedRewardRequest;
use App\Http\Requests\Reward\UpdateRedeemedRewardRequest;
use App\Http\Requests\Reward\UpdateUserRewardRequest;
use App\Models\RedeemedReward;

class RedeemedRewardController extends Controller
{
    public function index()
    {
        return response()->json(RedeemedReward::with('reward', 'user')->get());
    }

    public function store(StoreRedeemedRewardRequest $request)
    {
        $redeemedReward = RedeemedReward::create($request->validated());

        return response()->json($redeemedReward, 201);
    }

    public function show(RedeemedReward $redeemedReward)
    {
        return response()->json($redeemedReward->load('reward', 'user'));
    }

    public function update(UpdateRedeemedRewardRequest $request, RedeemedReward $redeemedReward)
    {

        $redeemedReward->update($request->validated());

        return response()->json($redeemedReward);
    }

    public function destroy(RedeemedReward $redeemedReward)
    {
        $redeemedReward->delete();

        return response()->json(null, 204);
    }
}
