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
        Schema::table('flight_records', function (Blueprint $table) {
            $table->dateTime("payment_expires_at")->nullable()->before("amount");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_records', function (Blueprint $table) {
            $table->dropColumn("payment_expires_at");
        });
    }
};