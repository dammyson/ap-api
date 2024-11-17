<?php

namespace App\Services\Point;

use App\Models\TierPoint;
use App\Models\TierPointTransaction;
use Carbon\Carbon;

class TierPointService
{
    public function addPoints($userId, $points, $validForDays = 365)
    {
        $expiresAt = Carbon::now()->addDays($validForDays);

        // Update total points in the TierPoint model
        $tierPoint = TierPoint::firstOrCreate(
            ['user_id' => $userId],
            ['total_points' => 0] // Ensure total_points has a default value on creation
        );
        $tierPoint->total_points += $points;
        $tierPoint->save();

        // Create a new transaction for this addition
        TierPointTransaction::create([
            'user_id' => $userId,
            'points' => $points,
            'expires_at' => $expiresAt,
        ]);
    }

    public function clearExpiredTransactions($userId)
    {
        // Find expired transactions and deduct from total points
        $expiredTransactions = TierPointTransaction::where('user_id', $userId)
            ->whereDate('expires_at', '<', Carbon::now())
            ->get();

        $expiredPoints = $expiredTransactions->sum('points');

        // Update the user's total points
        if ($expiredPoints > 0) {
            $tierPoint = TierPoint::where('user_id', $userId)->first();
            if ($tierPoint) {
                $tierPoint->total_points = max(0, $tierPoint->total_points - $expiredPoints);
                $tierPoint->save();
            }
        }

        // Delete expired transactions
        TierPointTransaction::where('user_id', $userId)
            ->whereDate('expires_at', '<', Carbon::now())
            ->delete();
    }
}
