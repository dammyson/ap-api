<?php

namespace App\Observers;

use App\Models\Admin;
use App\Models\Admin\AdminActivityLog;

class AdminObserver
{
    /**
     * Handle the Admin "created" event.
     */
    public function created(Admin $admin): void
    {
        // $creatorAdmin = auth('admin')->user();
        // $description = "Created new user account {$admin->user_name} with user ID: {$admin->id} and role {$admin->role}";

        // AdminActivityLog::create([
        //     'admin_id' => $creatorAdmin->id,
        //     'role' => $creatorAdmin->role,
        //     'activity_type' => "User management",
        //     'description' => $description,
        //     'ip_address' => request()->ip()
        // ]);
    }

    /**
     * Handle the Admin "updated" event.
     */
    public function updated(Admin $admin): void
    {   
        // if admin is not logged in skip the activity log;
        if (auth('admin')->user()) {

            $creatorAdmin = auth('admin')->user();
            $previousRole = $admin->getOriginal('role'); // Get the previous role before the update
            $newRole = $admin->role; // The updated role
    
            $description = "Edited user role {$admin->user_name} for {$previousRole} to {$newRole}";
            
            AdminActivityLog::create([
                'admin_id' => $creatorAdmin->id,
                'role' => $creatorAdmin->role,
                'activity_type' => "User management",
                'description' => $description,
                'ip_address' => request()->ip()
            ]);
        }
    }

    /**
     * Handle the Admin "deleted" event.
     */
    public function deleted(Admin $admin): void
    {
        $creatorAdmin = auth('admin')->user();
        $description = "Deleted user account {$admin->user_name} with ID {$admin->id}";
        
        AdminActivityLog::create([
            'admin_id' => $creatorAdmin->id,
            'role' => $creatorAdmin->role,
            'activity_type' => "User management",
            'description' => $description,
            'ip_address' => request()->ip()
        ]);
    }

    /**
     * Handle the Admin "restored" event.
     */
    public function restored(Admin $admin): void
    {
        //
    }

    /**
     * Handle the Admin "force deleted" event.
     */
    public function forceDeleted(Admin $admin): void
    {
        //
    }
}
