<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FlightController;


Route::post('/search-flights', [FlightController::class, 'searchFlights']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
