<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        return response()->json(Reward::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer',
        ]);

        $reward = Reward::create($validated);

        return response()->json($reward, 201);
    }

    public function show(Reward $reward)
    {
        return response()->json($reward);
    }

    public function update(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer',
        ]);

        $reward->update($validated);

        return response()->json($reward);
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();

        return response()->json(null, 204);
    }
}
