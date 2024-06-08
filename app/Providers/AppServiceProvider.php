<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Ticket\PassengerTicketService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PassengerTicketService::class, function ($app) {
            return new PassengerTicketService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
