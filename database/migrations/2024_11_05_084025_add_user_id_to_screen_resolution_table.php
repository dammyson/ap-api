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
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('screen_resolutions', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign('user_id');
        
            // Optionally, drop the index if it’s not needed for anything else
            $table->dropIndex('user_id');
            
        });
    }
};
