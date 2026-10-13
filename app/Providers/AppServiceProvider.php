<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Http\Request;
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
use App\Services\Payment\Payments;
use App\Services\Transaction\Transactions;
use Illuminate\Support\Facades\RateLimiter;

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
        $this->app->singleton(Payments::class, function ($app) {
            return new Payments();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   

        RateLimiter::for('global-rate-limiter', function (Request $request) {
            $limits = [
                Limit::perMinute(60)
                    ->by('ip:' . $request->ip())
                    ->response(function (Request $request, array $headers) {
                        return response()->json([
                            'message' => 'Too many requests. Please try again later.',
                        ], 429, $headers);
                    }),
            ];

            if ($user = $request->user()) {
                $limits[] = Limit::perMinute(120)
                    ->by('user:' . $user->id)
                    ->response(function (Request $request, array $headers) {
                        return response()->json([
                            'message' => 'Too many requests. Please try again later.',
                        ], 429, $headers);
                    });
            }

            return $limits;
        });

        RateLimiter::for('auth-sensitive', function (Request $request) {
            return Limit::perMinute(5)
                ->by('login-ip:' . $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Too many attempts. Please try again later.',
                    ], 429, $headers);
                });
        });

        Gate::define('is-admin', function(Admin $admin) {
          
            return $admin->role == 'admin' ? Response::allow()
                : Response::deny('You must be an admin');
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
        
    }

    
    

}
