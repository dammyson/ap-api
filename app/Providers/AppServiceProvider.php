<?php

namespace App\Providers;

use App\Events\AdminCustomerEvent;
use App\Models\Admin;
use App\Events\AdminLoginEvent;
use App\Events\AdminSurveyEvent;
use App\Events\UserActivityLogEvent;
use App\Listeners\AdminCustomerListener;
use App\Observers\AdminObserver;
use App\Listeners\AdminLoginListener;
use App\Listeners\AdminSurveyListener;
use App\Listeners\UserActivityLogListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Services\Transaction\Transactions;
use App\Services\Ticket\PassengerTicketService;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Transactions::class, function ($app) {
            return new Transactions();
        });

        $this->app->singleton(PassengerTicketService::class, function ($app) {
            return new PassengerTicketService($app->make(Transactions::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::define('is-admin', function(Admin $admin) {
            // dd($admin);
            return $admin->role == 'Admin';
        });
       

        
        
        Admin::observe(AdminObserver::class);

        
        Event::listen(
            AdminLoginEvent::class,
            AdminLoginListener::class,
        );

        Event::listen(
            AdminSurveyEvent::class,
            AdminSurveyListener::class
        );

        Event::listen(
            AdminCustomerEvent::class,
            AdminCustomerListener::class
        );

        Event::listen(
            UserActivityLogEvent::class,
            UserActivityLogListener::class
        );
    }

}
