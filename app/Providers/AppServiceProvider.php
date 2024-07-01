<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Ticket\PassengerTicketService;
use App\Services\Transaction\Transactions;

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
        //
    }
}
