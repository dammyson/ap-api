<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.  docker-compose run --rm artisan migrate:refresh --path=/database/migrations/2024_10_27_000359_create_tier_points_table.php
     */
    public function up(): void
    {
        Schema::create('tier_points', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('total_points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tier_points');
    }
};
