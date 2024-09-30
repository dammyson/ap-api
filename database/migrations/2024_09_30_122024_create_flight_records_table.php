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
        Schema::create('flight_records', function (Blueprint $table) {
            $table->id();
            $table->string('origin');
            $table->string('destination');
            $table->dateTime('arrival_time');
            $table->dateTime('departure_time');
            $table->string('peace_id');
            $table->string('passenger_type');
            $table->string('quantity_of passenger');
            $table->string('phone_number')->nullable();
            $table->string('trip_type');
            $table->string('booking_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_records');
    }
};
