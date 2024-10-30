<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_user_response_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_user_response_id')->constrained()->onDelete('cascade');
            $table->foreignId('option_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('survey_user_response_option')->insert(
            DB::table('survey_user_responses')->select('id as survey_user_response_id', 'option_id')->whereNotNull('option_id')->get()->toArray()
        );

        Schema::table('survey_user_responses', function (Blueprint $table) {
            $table->dropForeign(['option_id']); // Drop the foreign key
            $table->dropColumn('option_id'); // Drop the option_id column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the migration 
        Schema::table('survey_user_responses', function (Blueprint $table) {
            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
        });

        // Remove data from the pivot table if necessary (optional)
        Schema::dropIfExists('survey_user_response_option');
    }
};
