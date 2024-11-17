<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.  docker-compose run --rm artisan migrate:refresh --path=/database/migrations/2024_10_27_000418_create_tier_point_transactions_table.php
     */
    public function up(): void
    {
        Schema::create('tier_point_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('points');
            $table->date('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tier_point_transactions');
    }
};
