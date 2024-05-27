<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RegisterController;


Route::group(['prefix' => 'user'], function () use ($router) {
    $router->post('register', [RegisterController::class, 'clientRegister']);
    $router->post('forgot-password', [RegisterController::class, 'forgotPassword']);
    $router->post('verify/otp', [RegisterController::class, 'verifyOtp']); 
    $router->post('reset/password', [RegisterController::class, 'resetPassword']); 
    $router->post('change/password', [RegisterController::class, 'changePassword']); 
    $router->post('login', [LoginController::class, 'login']);
  

});

Route::group(["middleware" => ["auth:api"]], function () {
    Route::post('/search-flights', [FlightController::class, 'searchFlights']);
    Route::get('/country', [CityController::class, 'indexCountry']);
    Route::post('/country', [CountryController::class, 'storeCountry']);
    Route::get('/city', [CityController::class, 'indexCity']);
    Route::post('/city', [CityController::class, 'storeCity']);
    Route::get('/plane', [PlaneController::class, 'indexPlane']);
    Route::post('/plane', [PlaneController::class, 'storePlane']);

});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
