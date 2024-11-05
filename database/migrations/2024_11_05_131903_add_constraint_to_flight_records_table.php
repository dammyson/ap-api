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
        Schema::table('flight_records', function (Blueprint $table) {
            // Assuming 'peace_id' references the 'peace_id' column in 'users' table
            $table->foreign('peace_id')->references('peace_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_records', function (Blueprint $table) {
            $table->dropForeign('peace_id');
        });
    }
};
