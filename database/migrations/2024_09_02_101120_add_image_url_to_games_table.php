<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. docker-compose run --rm artisan migrate:refresh --path=/database/migrations/2024_09_02_101120_add_image_url_to_games_table.php
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
