<?php

namespace App\Listeners;

use App\Events\AdminSurveyEvent;
use App\Models\Admin\ActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdminSurveyListener
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
    public function handle(AdminSurveyEvent $event): void
    {
       $admin = $event->admin;
       $survey = $event->survey;
       $action = $event->action;
       
       if ($admin instanceOf \App\Models\Admin) {
           $description = `Admin {$admin->user_name} {$action} {$survey->title}`;
    
            ActivityLog::create([
                'admin_id' => $admin->id,
                'role' => $admin->role,
                'activity_type' => "Login",
                'description' => $description,
                'ip_address' => request()->ip()
            ]);

       }



    }
}
