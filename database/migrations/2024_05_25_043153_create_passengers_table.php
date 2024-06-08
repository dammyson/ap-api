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
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('user_category'); 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth');
            $table->string('sex');
            $table->string('country');
            $table->string('passport_number')->nullable();
            $table->boolean('is_blind')->default(false);
            $table->boolean('is_deaf')->default(false);
            $table->boolean('needs_mobility_assistance')->default(false);
            $table->boolean('is_contact_person')->default(false);
            $table->string('invoice_type')->default('personal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
