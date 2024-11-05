<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('screen_resolutions', function (Blueprint $table) {
            $table->dropColumn('number_of_users');
        });

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('screen_resolutions', function (Blueprint $table) {
            $table->string('number_of_users');
        });
    }
};
