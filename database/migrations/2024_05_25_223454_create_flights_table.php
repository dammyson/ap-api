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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');
            $table->foreignId("plane_id")->constrained()->cascadeOnDelete();
            $table->foreignId("origin_id")->constrained("airports")->cascadeOnDelete();
            $table->foreignId("destination_id")->constrained("airports")->cascadeOnDelete();
            $table->dateTime("departure");
            $table->dateTime("arrival");
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
