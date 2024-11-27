<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Http\SoapClientService;

class CraneReissuePnrOTAServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton('CraneReissuePnrOTAService', function ($app) {
            $wsdl = 'https://apk-stage.crane.aero//craneota/CraneReissuePnrOTAService?wsdl';
            return new SoapClientService($wsdl);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
