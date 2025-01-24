<?php

namespace App\Console\Commands;

use App\Models\Admin\Survey;
use Illuminate\Console\Command;
use Google\Service\Texttospeech\Turn;

class DeactivateExpiredSurveys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deactivate-expired-surveys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredSurveys = Survey::where('is_active', true)
            ->where('is_published', true)
            ->whereRaw("DATE_ADD(updated_at, INTERVAL duration_of_survey MINUTE) <= NOW()")
            ->first();

        $expiredSurveys->is_active = false;
        $expiredSurveys->save();
    }

}