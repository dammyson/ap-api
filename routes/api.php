<?php

use App\Http\Controllers\AirportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameRuleController;
use App\Http\Controllers\GamePlayController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\RedeemedRewardController;



Route::get('/soap', [FlightController::class, 'callSoapApi']);



Route::group(['prefix' => 'user'], function () use ($router) {
    $router->post('register', [RegisterController::class, 'userRegister']);
    $router->post('forgot-password', [RegisterController::class, 'forgotPassword']);
    $router->post('verify/otp', [RegisterController::class, 'verifyOtp']);
    $router->post('reset/password', [RegisterController::class, 'resetPassword']);
    $router->post('change/password', [RegisterController::class, 'changePassword']);
    $router->post('login', [LoginController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'admin/'], function () {
        Route::post('/country', [CountryController::class, 'storeCountry']);
        Route::post('/city', [CityController::class, 'storeCity']);
        Route::post('/plane', [PlaneController::class, 'storePlane']);
        Route::post('game-categories', [GameCategoryController::class, 'store']);
        Route::post('games', [GameController::class, 'store']);
    });
});


Route::group(["middleware" => ["auth:api"]], function () {
    Route::post('/search-flights', [FlightController::class, 'searchFlights']);
    Route::get('/country', [CountryController::class, 'indexCountry']);
    Route::get('/city', [CityController::class, 'indexCity']);
    Route::get('/plane', [PlaneController::class, 'indexPlane']);
    Route::get('/airport', [AirportController::class, 'indexAirport']);
    Route::post('/airport', [AirportController::class, 'storeAirport']);
    Route::post('/passenger/tickets', [TicketController::class, 'storeMultipleTickets']);
    Route::post('/tickets/update-seats', [TicketController::class, 'updateSeats']);
    Route::get('/booking', [BookingController::class, 'getBooking']);
});


Route::group(["middleware" => ["auth:api"]], function () {

    Route::get('game-categories', [GameCategoryController::class, 'index']);
    Route::get('game-categories/{gameCategory}', [GameCategoryController::class, 'show']);
    Route::put('game-categories/{gameCategory}', [GameCategoryController::class, 'update']);
    Route::delete('game-categories/{gameCategory}', [GameCategoryController::class, 'destroy']);

    Route::get('games', [GameController::class, 'index']);
    Route::get('games/{game}', [GameController::class, 'show']);
    Route::put('games/{game}', [GameController::class, 'update']);
    Route::delete('games/{game}', [GameController::class, 'destroy']);

    Route::get('game-rules', [GameRuleController::class, 'index']);
    Route::post('game-rules', [GameRuleController::class, 'store']);
    Route::get('game-rules/{gameRule}', [GameRuleController::class, 'show']);
    Route::put('game-rules/{gameRule}', [GameRuleController::class, 'update']);
    Route::delete('game-rules/{gameRule}', [GameRuleController::class, 'destroy']);

    Route::get('game-plays', [GamePlayController::class, 'index']);
    Route::post('game-plays', [GamePlayController::class, 'store']);
    Route::get('game-plays/{gamePlay}', [GamePlayController::class, 'show']);
    Route::put('game-plays/{gamePlay}', [GamePlayController::class, 'update']);
    Route::delete('game-plays/{gamePlay}', [GamePlayController::class, 'destroy']);

    Route::get('rewards', [RewardController::class, 'index']);
    Route::post('rewards', [RewardController::class, 'store']);
    Route::get('rewards/{reward}', [RewardController::class, 'show']);
    Route::put('rewards/{reward}', [RewardController::class, 'update']);
    Route::delete('rewards/{reward}', [RewardController::class, 'destroy']);

    Route::get('redeemed-rewards', [RedeemedRewardController::class, 'index']);
    Route::post('redeemed-rewards', [RedeemedRewardController::class, 'store']);
    Route::get('redeemed-rewards/{redeemedReward}', [RedeemedRewardController::class, 'show']);
    Route::put('redeemed-rewards/{redeemedReward}', [RedeemedRewardController::class, 'update']);
    Route::delete('redeemed-rewards/{redeemedReward}', [RedeemedRewardController::class, 'destroy']);
});
