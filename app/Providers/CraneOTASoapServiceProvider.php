<?php
namespace App\Providers;

use App\Services\Http\SoapClientService;
use Illuminate\Support\ServiceProvider;


class CraneOTASoapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CraneOTASoapService', function ($app) {
            $wsdl = 'https://apk-stage.crane.aero//craneota/CraneOTAService?wsdl';
            return new SoapClientService($wsdl);
        });
    }
}