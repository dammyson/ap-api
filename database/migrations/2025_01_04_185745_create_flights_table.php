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
            $table->string('origin');
            $table->string('destination');
            $table->dateTime('arrival_time');
            $table->dateTime('departure_time');
            $table->string('peace_id')->nullable();
            $table->foreign('peace_id')->references('peace_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('guest_session_token')->nullable();
            $table->string('passenger_type');           
            $table->string('trip_type');
            $table->string('booking_id');
            $table->dateTime("payment_expires_at");
            $table->string('passenger_name');
            $table->string('origin_city');
            $table->string('destination_city');
            $table->string('ticket_type');
            $table->integer('flight_distance');
            $table->string('flight_duration');
            $table->string('flight_number');
            $table->foreignUuid('invoice_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_flight');
    }
};
