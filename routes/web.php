<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TestPaymentController;
use App\Http\Controllers\AnalyticsUserController;
use App\Http\Controllers\Test\ReissuePNRController;
use App\Http\Controllers\Guest\GuestLoginController;
use App\Http\Controllers\Test\AddWeightControllerTest;


// Route::prefix('guest')->middleware('web')->group(function () {
//     Route::get('continue-as-guest', [GuestLoginController::class, 'continueAsGuest']);
//     Route::post('search-flights', [FlightController::class, 'searchFlightsForWeb']);
//     Route::get('upcoming-trips', [AnalyticsUserController::class, 'guestUpcomingTrips']);
//     Route::get('trip-history', [AnalyticsUserController::class, 'tripHistory']);
//     Route::post('/ref', [TestPaymentController::class, 'verifyTicketRef'])->name('wallet.top_up');
//     Route::post('preview', [ReissuePNRController::class, 'reissueTicketPNR']);
//     Route::post('commit', [ReissuePNRController::class, 'reissueTicketCommit']);
//     Route::post('/add-weight-bag-ow/invoice-test/{invoiceId}/{ssrType}', [AddWeightControllerTest::class, 'addWeightTest']);
//     Route::post('/select-seat-test', [AddWeightControllerTest::class, 'selectSeatTest']);


// });

Route::get('/', function () {
    return view('welcome');
});