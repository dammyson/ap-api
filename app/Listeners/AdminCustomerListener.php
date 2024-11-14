<?php

namespace App\Listeners;

use App\Models\Admin\ActivityLog;
use App\Events\AdminCustomerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCustomerListener
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
    public function handle(AdminCustomerEvent $event): void
    {
        $admin = $event->admin;
        $user = $event->user;
        $points = $event->points;
        $reason = $event->reason;

        $description = "Admin {$admin->user_name} shared {$points} points to {$user->first_name} {$user->last_name} reason : {$reason}"; 
        
        ActivityLog::create([
            'admin_id' => $admin->id,
            'role' => $admin->role,
            'activity_type' => "Point allocation",
            'description' => $description,
            'ip_address' => request()->ip()
        ]);
    }
}
