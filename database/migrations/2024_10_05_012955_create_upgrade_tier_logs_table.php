<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations.  docker-compose run --rm artisan migrate:refresh --path=/database/migrations/2024_10_05_012955_create_upgrade_tier_logs_table.php
     */

    public function up(): void
    {
        Schema::create('upgrade_tier_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('old_tier_id')->nullable()->constrained('tiers');
            $table->foreignId('new_tier_id')->constrained('tiers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upgrade_tier_logs');
    }
};
