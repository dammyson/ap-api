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

        // if ($tier) {
        //     // Associate the new tier with the user
        //     $user->tiers()->attach($tier);
        //     $user->save();

        //     // Optionally, you can notify the user or perform additional actions
        //     return response()->json([
        //         'message' => 'Tier upgraded successfully!',
        //         "user" => $user
        //     ]);
        // }

        if ($tier) {
            $currentTier = $user->currentTier(); 
            $user->tiers()->updateExistingPivot($currentTier?->id, ['is_current' => false]);

            if ($currentTier->rank > $tier->rank) {
                return response()->json([
                    "error" => true,
                    "message" => "user already in a higher tier"
                ], 400);
            } else if ($currentTier->rank == $tier->rank) {
                return response()->json([
                    "error" => true,
                    "message" => "cannot upgrade same tier"
                ], 500);
            }
              // Assign the higher tier
            $user->tiers()->attach($tier->id, [
                'is_current' => true,
                'expires_at' => null, // Reset expiration for calculated tiers
                'source' => 'calculated',
            ]);
            $user->tier_id = $tier->id;
            $user->save();
            // $user->load('tiers');

            return response()->json([
                'message' => 'Tier upgraded successfully!',
                "user" => $user
            ]);

        }

        return response()->json(['message' => 'Tier upgrade failed.'], 500);
    }
}
