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
        
        Schema::create('referral_activities', function (Blueprint $table) {
            $table->id();
            $table->string('referrer_peace_id');
            $table->string('referrer_user_name');
            $table->string('referee_peace_id');
            $table->string('referee_user_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_activities');
    }
};
