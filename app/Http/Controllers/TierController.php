<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tier;
use Illuminate\Support\Facades\Auth;

class TierController extends Controller
{
    /**
     * Upgrade the user's tier.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upgradeTier(Request $request)
    {
        // Validate the request to ensure a valid tier_id is provided
        $request->validate([
            'tier_id' => 'required|exists:tiers,id',
        ]);

        // Get the authenticated user
        // $user = Auth::user();

        $user = $request->user();
        
        // Find the new tier
        $tier = Tier::find($request->input('tier_id'));

        if ($tier) {
            // Associate the new tier with the user
            $user->tiers()->attach($tier);
            $user->save();

            // Optionally, you can notify the user or perform additional actions
            return response()->json(['message' => 'Tier upgraded successfully!']);
        }

        return response()->json(['message' => 'Tier upgrade failed.'], 500);
    }
}
