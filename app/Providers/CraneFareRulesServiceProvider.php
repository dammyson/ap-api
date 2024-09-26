<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Http\SoapClientService;

class CraneFareRulesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('CraneFareRulesService', function ($app) {
            $wsdl = 'https://apk-stage.crane.aero//craneota/CraneFareRulesService?wsdl';
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
