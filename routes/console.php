<?php

use App\Models\Admin\Survey;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {
    $expiredSurveys = Survey::where('is_active', true)
        ->where('is_published', true)
        ->whereRaw("DATE_ADD(updated_at, INTERVAL duration_of_survey MINUTE) <= NOW()")
        ->first();

    $expiredSurveys->is_active = false;
    $expiredSurveys->is_published = false;
    $expiredSurveys->save();

    // foreach ($expiredSurveys as $survey) {
    //     $survey->update(['is_active' => false]);
    //     logger()->info("Deactivated Survey ID: {$survey->id}");
    // }
})->everyTwoMinutes(); // Adjust the frequency as needed

