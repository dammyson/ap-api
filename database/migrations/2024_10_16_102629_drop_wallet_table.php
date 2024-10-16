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
        Schema::dropIfExists('wallet');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('wallet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('balance', 10, 2); 
            $table->decimal('ledger_balance', 10, 2);
            $table->string('reference')->nullable();
            $table->timestamps();
        });
    }
};
