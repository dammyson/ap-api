<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Admin\SurveyUserResponse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'peace_id',
        'password',
        'image_url',
        'title',
        'nationality',
        'date_of_birth',
        'travel_document',
        'tier_id',
        'status',
        'points',
        'all_time_point',
        'device_type',
        'firebase_token',
        'is_guest'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function surveyUserResponses()
    {
        return $this->hasMany(SurveyUserResponse::class);
    }

    public function tiers()
    {
        return $this->belongsToMany(Tier::class, 'tier_users')
            ->withPivot('is_current', 'expires_at')
            ->withTimestamps();
    }

    public function referralActivitiesReferee() {
        return $this->hasOne(ReferralActivity::class, 'referee_peace_id', 'peace_id');
    }

    public function referralActivitiesAsReferrer() {
        return $this->hasMany(ReferralActivity::class, 'referrer_peace_id', 'peace_id');
    }

    // Define the relationship with Flight
    public function flights()
    {
        return $this->hasMany(Flight::class, 'peace_id', 'peace_id');
    }
    public function currentTier()
    {
        return $this->tiers()->wherePivot('is_current', true)->first();
    }

    public function currentTierSource()
    {
        $currentTier = $this->currentTier();
        return $currentTier ? $currentTier->pivot->source : null;
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }


    public function addPoints($points, $description = null)
    {
        // Update the user's points
        $this->points += $points;
        $this->all_time_point += $points;
        $this->save();

        // Log the transaction
        $this->pointTransactions()->create([
            'points' => $points,
            'type' => 'add',
            'description' => $description ?? 'Points added',
        ]);

        // Check and update tier
        $this->assignTierWithDefaultFallback();
    }

    public function assignTierWithDefaultFallback()
    {
        $currentTier = $this->currentTier();

        // Determine the highest tier the user qualifies for based on points
        $highestTier = Tier::where('minimum_points', '<=', $this->points)
            ->orderBy('rank', 'desc') // Higher tiers have lower rank values
            ->orderBy('minimum_points', 'desc') // Break ties with points
            ->first();

        // If user qualifies for a higher tier, promote them immediately
        if ($highestTier && (!$currentTier || $highestTier->rank > $currentTier->rank)) {
            // Clear the previous current tier
            $this->tiers()->updateExistingPivot($currentTier?->id, ['is_current' => false]);

            // Assign the higher tier
            $this->tiers()->attach($highestTier->id, [
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
                $this->tiers()->updateExistingPivot($currentTier->id, ['is_current' => false]);

                // Assign the lower or default tier
                $this->tiers()->attach($lowerTier->id, [
                    'is_current' => true,
                    'expires_at' => null, // Reset expiration for calculated tiers
                    'source' => 'calculated',
                ]);
            }
        }
    }



    public function deductPoints($points, $description = null)
    {
        if ($this->points < $points) {
            throw new \Exception('Insufficient points');
        }

        $this->points -= $points;
        $this->save();

        // Log the transaction
        $this->pointTransactions()->create([
            'points' => $points,
            'type' => 'deduct',
            'description' => $description ?? 'Points deducted',
        ]);

        // Check and update tier
        $this->assignTierWithDefaultFallbackOnDeduction();
    }
    public function assignTierWithDefaultFallbackOnDeduction()
    {
        $currentTier = $this->currentTier();

        // If the current tier has not expired, extend its expiry date by one month
        if ($currentTier && (!$currentTier->pivot->expires_at || Carbon::now()->lte($currentTier->pivot->expires_at))) {
            $this->tiers()->updateExistingPivot($currentTier->id, [
                'expires_at' => Carbon::now()->addMonth(),
            ]);
            return;
        }

        // Find a new tier based on points if the current tier has expired
        $tier = Tier::where('minimum_points', '<=', $this->points)
            ->orderBy('minimum_points', 'desc')
            ->first();

        if (!$tier) {
            // If no tier matches the points, assign the default tier
            $defaultTier = Tier::where('is_default', true)->first();
            if ($currentTier && $defaultTier && $currentTier->id === $defaultTier->id) {
                return;
            }
            $this->tiers()->updateExistingPivot($currentTier?->id, ['is_current' => false]);
            $this->tiers()->attach($defaultTier->id, ['is_current' => true, 'expires_at' => Carbon::now()->addMonth(),  'source' => 'calculated',]);
        }

        if ($tier && (!$currentTier || $tier->id !== $currentTier->id)) {
            $this->tiers()->updateExistingPivot($currentTier?->id, ['is_current' => false]);
            $this->tiers()->attach($tier->id, ['is_current' => true, 'expires_at' => Carbon::now()->addMonth(),  'source' => 'calculated',]);
        }
    }
}
