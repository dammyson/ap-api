<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AnalyticsUserController;
use App\Http\Controllers\Test\ReissuePNRController;
use App\Http\Controllers\Guest\GuestLoginController;
use App\Http\Controllers\Test\AddWeightControllerTest;


Route::get('/', function () {
    return view('welcome');
});
