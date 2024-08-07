<?php
namespace App\Providers;

use App\Services\Http\SoapClientService;
use Illuminate\Support\ServiceProvider;


class CraneAncillaryOTASoapServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CraneAncillaryOTASoapService', function ($app) {
            $wsdl = 'https://apk-stage.crane.aero//craneota/CraneAncillaryOTAService?wsdl';
            return new SoapClientService($wsdl);
        });
    }
}