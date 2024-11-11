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
            $table->string('origin_city');
            $table->string('destination_city');
            $table->string('ticket_type');
            $table->integer('flight_distance');
            $table->string('flight_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flight_records', function (Blueprint $table) {
            $table->dropColumn('origin_city');
            $table->dropColumn('destination_city');
            $table->dropColumn('ticket_type');
            $table->dropColumn('flight_distance');
            $table->dropColumn('flight_duration');
        });
    }
};
