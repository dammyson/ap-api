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
        Schema::table('transaction_records', function (Blueprint $table) {
            $table->string('device_type');
            $table->string('day_of_week');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_records', function (Blueprint $table) {
            $table->dropColumn('device_type');
            $table->dropColumn('day_of_week');
        });
    }
};
