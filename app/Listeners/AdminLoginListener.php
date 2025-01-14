<?php

namespace App\Listeners;

use App\Events\AdminLoginEvent;
use App\Models\Admin\ActivityLog;
use App\Models\Admin\AdminActivityLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminLoginListener
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
    // public function handle(IlluminateAuthEventsLogin $event): void
    // {
    //     //
    // }

    public function handle(AdminLoginEvent $event): void
    {
        // Check if the logged-in user is an admin
        if ($event->admin instanceof \App\Models\Admin) {
            $admin = $event->admin;
            $description = "Admin {$admin->user_name} has logged in.";
            
            AdminActivityLog::create([
                'admin_id' => $admin->id,
                'role' => $admin->role,
                'activity_type' => "Login",
                'description' => $description,
                'ip_address' => request()->ip()
            ]);
        }
    }
}
