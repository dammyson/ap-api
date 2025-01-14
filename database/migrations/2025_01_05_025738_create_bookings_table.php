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
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('booking_id');
            $table->string('booking_reference_id');
            $table->string('peace_id')->nullable();
            $table->string('last_name');
            $table->foreignUuid('invoice_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('guest_session_token')->nullable();
            $table->boolean('is_cancelled')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_bookings');
    }
};
