<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use App\Events\AdminLoginEvent;
use App\Events\AdminSurveyEvent;
use App\Observers\AdminObserver;
use App\Events\AdminCustomerEvent;
use App\Events\UserActivityLogEvent;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use App\Listeners\AdminLoginListener;
use Illuminate\Support\Facades\Event;
use App\Listeners\AdminSurveyListener;
use Illuminate\Support\ServiceProvider;
use App\Listeners\AdminCustomerListener;
use Illuminate\Cache\RateLimiting\Limit;
use App\Listeners\UserActivityLogListener;
use App\Services\Transaction\Transactions;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\Ticket\PassengerTicketService;

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

        RateLimiter::for('global-rate-limiter', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip())->response(function (Request $request, array $headers) {
                return response('Amount of request per minute exceeded', 429, $headers);
            });
        });

        Gate::define('is-admin', function(Admin $admin) {
          
            return $admin->role == 'admin' ? Response::allow()
                : Response::deny('You must be an admin');;
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
        
        // Set Passport token expiration logic here
        Passport::tokensExpireIn(now()->addHours(2)); // Access token expiration (2 hours)
    
        Passport::refreshTokensExpireIn(now()->addHours(2)); 
    }

    
    

}
