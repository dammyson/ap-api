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
        Schema::create('user_insu_terms_acceptances', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignUuid('insu_terms_and_conds_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('content_hash')->nullable();
            
            $table->timestamp('accepted_at');

            $table->ipAddress('ip_address')->nullable();

            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_insu_terms_acceptances');
    }
};
