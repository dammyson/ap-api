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
        Schema::table('referral_activities', function (Blueprint $table) {
            $table->foreign('referrer_peace_id')->references('peace_id')->on('users')->onDelete('cascade');            
            $table->foreign('referee_peace_id')->references('peace_id')->on('users')->onDelete('cascade');
            $table->integer('referrer_points_earned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referral_activities', function (Blueprint $table) {

              // Drop foreign key constraints
              $table->dropForeign(['referrer_peace_id']);
              $table->dropForeign(['referee_peace_id']);

              // Drop points
              $table->dropColumn('referrer_points_earned');
        });
    }
};
