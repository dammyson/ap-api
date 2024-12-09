<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tier;



class TierSeeder extends Seeder
{
    public function run()
    {
        $tiers = [
            [
                'name' => 'Bronze',
                'rank'=> 1,
                'description' => 'Entry-level tier with basic benefits',
                'discount' => 0,
                'minimum_points' => 0,
                'is_default' => true, // Set as default tier
            ],
            [
                'name' => 'Silver',
                'rank'=> 2,
                'description' => 'Intermediate tier with moderate benefits',
                'discount' => 5, // 5% discount
                'minimum_points' => 100,
                'is_default' => false,
            ],
            [
                'name' => 'Gold',
                'rank'=> 3,
                'description' => 'Advanced tier with great benefits',
                'discount' => 10, // 10% discount
                'minimum_points' => 500,
                'is_default' => false,
            ],
            [
                'name' => 'Platinum',
                'rank'=> 4,
                'description' => 'Premium tier with maximum benefits',
                'discount' => 20, // 20% discount
                'minimum_points' => 1000,
                'is_default' => false,
            ],
        ];

        foreach ($tiers as $tier) {
            Tier::create($tier);
        }
    }
}
