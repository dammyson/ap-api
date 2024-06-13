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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("passenger_id")->constrained()->cascadeOnDelete();
            $table->foreignId("flight_id")->constrained()->cascadeOnDelete();
            $table->string("seat_number");
            $table->tinyInteger("status")->default(0)->comment("0: pendding, 1: accepted, 2: canceled");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
