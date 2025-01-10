<?php

namespace App\Listeners;

use App\Models\UserActivityLog;
use App\Events\UserActivityLogEvent;
use App\Models\RecentActivity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserActivityLogListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserActivityLogEvent $event): void
    {
        $user = $event->user;
        $activityType = $event->activityType;
        $description = $event->description;

        if ($user instanceof \App\Models\User) {
            UserActivityLog::create([
                'user_id' => $user->id,
                'activity_type' => $activityType,
                'description' => $description
            ]);
        }

        // RecentActivity::create([
        //     'title' => $activityType,
        //     'description' => $description
        // ]);
    }
}
