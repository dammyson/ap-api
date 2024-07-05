<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reward\StoreRewardRequest;
use App\Http\Requests\Reward\UpdateRewardRequest;
use App\Models\Reward;

class RewardController extends Controller
{
    public function index()
    {
        return response()->json(Reward::all());
    }

    public function store(StoreRewardRequest $request)
    {

        $reward = Reward::create($request->validated());

        return response()->json($reward, 201);
    }

    public function show(Reward $reward)
    {
        return response()->json($reward);
    }

    public function update(UpdateRewardRequest $request, Reward $reward)
    {
        $reward->update($request->validated());

        return response()->json($reward);
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();

        return response()->json(null, 204);
    }
}
