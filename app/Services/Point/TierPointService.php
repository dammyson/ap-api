<?php

namespace App\Services\Point;

use App\Models\Tier;
use App\Models\User;
use Carbon\Carbon;

class TierPointService
{
    public function assignDefaultTier($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return;
        }

        $defaultTier = Tier::where('is_default', true)->first();

        if ($defaultTier) {
            $user->tiers()->updateExistingPivot($user->currentTier()?->id, ['is_current' => false]);
            $user->tiers()->attach($defaultTier->id, ['is_current' => true, 'expires_at' => null]);
        }
    }
    public function assignTierWithDefaultFallback($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return;
        }

        $currentTier = $user->currentTier();

        // Determine the highest tier the user qualifies for based on points
        $highestTier = Tier::where('minimum_points', '<=', $user->points)
            ->orderBy('rank', 'desc') // Higher tiers have lower rank values
            ->orderBy('minimum_points', 'desc') // Break ties with points
            ->first();

        // If user qualifies for a higher tier, promote them immediately
        if ($highestTier && (!$currentTier || $highestTier->rank > $currentTier->rank)) {
            // Clear the previous current tier
            $user->tiers()->updateExistingPivot($currentTier?->id, ['is_current' => false]);

            // Assign the higher tier
            $user->tiers()->attach($highestTier->id, [
                'is_current' => true,
                'expires_at' => null, // Reset expiration for calculated tiers
                'source' => 'calculated',
            ]);

            return;
        }

        // Handle expired tier: move to a lower or default tier
        if ($currentTier && $currentTier->pivot->expires_at && Carbon::now()->gt($currentTier->pivot->expires_at)) {
            // Find the best tier they now qualify for (or fallback to the default tier)
            $lowerTier = $highestTier ?: Tier::where('is_default', true)->first();
            // Update the user's tier only if it's different
            if ($lowerTier && (!$currentTier || $lowerTier->id !== $currentTier->id)) {
                // Clear the expired current tier
                $user->tiers()->updateExistingPivot($currentTier->id, ['is_current' => false]);

                // Assign the lower or default tier
                $user->tiers()->attach($lowerTier->id, [
                    'is_current' => true,
                    'expires_at' => null, // Reset expiration for calculated tiers
                    'source' => 'calculated',
                ]);
            }
        }
    }

    public function purchaseTier($userId, $tierId, $durationInDays)
    {
        $user = User::find($userId);
        $tier = Tier::find($tierId);

        if (!$user || !$tier) {
            throw new \Exception('User or Tier not found.');
        }

        $expiresAt = Carbon::now()->addDays($durationInDays);

        $user->tiers()->updateExistingPivot($user->currentTier()?->id, ['is_current' => false]);

        $user->tiers()->attach($tierId, [
            'is_current' => true,
            'expires_at' => $expiresAt,
            'source' => 'purchased',
        ]);
    }

    public function handleExpiredPurchasedTier($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return;
        }

        $currentTier = $user->currentTier();
        if ($currentTier && $currentTier->pivot->expires_at && Carbon::now()->gt($currentTier->pivot->expires_at)) {
            $user->tiers()->updateExistingPivot($currentTier->id, ['is_current' => false]);
            $this->assignTierWithDefaultFallback($userId);
        }
    }
}
