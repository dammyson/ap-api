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
        //
        Schema::dropIfExists('user_activity_log');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('user_activity_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascade('onUpdate')->cascade('onDelete');
            $table->string('activity_type');
            $table->string('description');
            $table->timestamps();
        });
    }
};
