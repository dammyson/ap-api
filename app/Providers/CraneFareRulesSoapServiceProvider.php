<?php

namespace App\Providers;

use App\Services\Http\SoapClientService;
use Illuminate\Support\ServiceProvider;

class CraneFareRulesSoapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('CraneFareRulesSoapService', function ($app) {
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
