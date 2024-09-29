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
        Schema::create('transaction_records', function (Blueprint $table) {
            $table->id();
            $table->string('user_name')->nullable();
            $table->string('peace_id')->nullable();
            $table->string('ticket_number')->nullable();
            $table->string('ticket_type')->nullable();
            $table->string('amount')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('reason_for_issuance')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('order_id')->nullable();
            $table->string('lead_passenger_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_records');
    }
};
