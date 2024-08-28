<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaneController;

use App\Http\Controllers\FlightController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\TicketController;
use App\Services\Soap\PenaltyRulesBuilder;
use App\Http\Controllers\AirportController;

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GamePlayController;
use App\Http\Controllers\GameRuleController;
use App\Http\Controllers\RegisterController;
use App\Services\Soap\VoidTicketRequestBuilder;
use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\Payment\FlutterwavePaymentController;
use App\Http\Controllers\Payment\PaystackPaymentController;
use App\Http\Controllers\Payment\PayzeepPaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Test\SeatMapController;
use App\Http\Controllers\RedeemedRewardController;
use App\Http\Controllers\Test\AddSeatController;
use App\Http\Controllers\Test\addWeightController;
use App\Http\Controllers\Test\AddWeightController as TestAddWeightController;
use App\Http\Controllers\Test\AvailableSpecialController;
use App\Http\Controllers\Test\VoidTicketController;
use App\Http\Controllers\Test\SegmentBaseController;
use App\Http\Controllers\Test\PenaltyRulesController;
use App\Http\Controllers\Test\GetAvailabilityController;
use App\Http\Controllers\Test\GetAirportMatrixController;
use App\Http\Controllers\Test\TicketReservationController;
use App\Http\Controllers\Test\Booking\BookingRequestController;
use App\Http\Controllers\Test\Booking\CancelBookingController;
use App\Http\Controllers\Test\Booking\CreateBookingController;
use App\Http\Controllers\Test\DivideDinerController;
use App\Http\Controllers\Test\DividePNRController;
use App\Http\Controllers\Test\GetAirExtraChargesAndProductController;
use App\Http\Controllers\Test\GetAirExtraChargesAndProductsController;

Route::get('/soap', [FlightController::class, 'callSoapApi']);


Route::group(['prefix' => 'user'], function ()  {
    Route::post('register', [RegisterController::class, 'userRegister']);
    Route::post('forgot-password', [RegisterController::class, 'forgotPassword']);
    Route::post('verify/otp', [RegisterController::class, 'verifyOtp']);
    Route::post('reset/password', [RegisterController::class, 'resetPassword']);
    Route::post('login', [LoginController::class, 'login']);
});


Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'admin/'], function () {
        Route::post('/country', [CountryController::class, 'storeCountry']);
        Route::post('/city', [CityController::class, 'storeCity']);
        Route::post('/plane', [PlaneController::class, 'storePlane']);
        Route::post('/airport', [AirportController::class, 'storeAirport']);
        Route::post('game-categories', [GameCategoryController::class, 'store']);
        Route::post('games', [GameController::class, 'store']);
    });
});


Route::group(["middleware" => ["auth:api"]], function() {
    Route::group(['prefix' => "soap/"], function () {
        Route::group(["prefix" => "void-ticket"], function() {
            Route::post('/pricing', [VoidTicketController::class, 'voidTicketPricing']);
            Route::post('/commit', [VoidTicketController::class, 'voidTicketCommit']);
        });

        Route::group(["prefix" => "ticket-reservation"], function() {
            Route::post('/view-only', [TicketReservationController::class, 'ticketReservationViewOnly']);
            Route::post('/view-only-rt', [TicketReservationController::class, 'ticketReservationViewOnlyRT']);
            Route::post('/view-only-two-a', [TicketReservationController::class, 'ticketReservationViewOnlyTwoA']);
            Route::post('/commit-two-a', [TicketReservationController::class, 'ticktReservationCommitTwoA']);
            Route::post('/commit', [TicketReservationController::class, 'ticketReservationCommit']);
            Route::post('/commit-rt', [TicketReservationController::class, 'ticketReservationCommitRT']);

        });

        Route::group(["prefix" => "booking"], function() {
            Route::group(["prefix" => "retrieve"], function() {
                Route::post('retrieve-pnr-history', [BookingRequestController::class, 'retrievePNRHistory']);
                Route::post('retrieve-ticket-history', [BookingRequestController::class, 'retrieveTicketHistory']);
            });

            Route::group(["prefix" => "read-booking"], function() {
                Route::post('read-booking-tk', [BookingRequestController::class, 'readBookingTK']);
                Route::post('read-booking', [BookingRequestController::class, 'readBooking']);
            });

            Route::group(["prefix" => "create-booking"], function() {
                Route::post('rt', [CreateBookingController::class, 'createBookingRT']);
                Route::post('ow', [CreateBookingController::class, 'createBookingOW']);
                Route::post('two-a', [CreateBookingController::class, 'createBookingTwoA']);
            });

        });
 
        Route::group(["prefix" => "get-availability"], function() {
            Route::post('general-parameters', [GetAvailabilityController::class, 'getAvailabilityGeneralParameters']);
            Route::post('get-availability-rt', [GetAvailabilityController::class, 'getAvailabilityRT']);
            Route::post('get-availability-ow', [GetAvailabilityController::class, 'getAvailabilityOW']);
            Route::post('get-availability-md', [GetAvailabilityController::class, 'getAvailabilityMD']);
            Route::post('get-availability-two-a', [GetAvailabilityController::class, 'getAvailabilityTwoA']);
        });

        Route::group(["prefix" => "get-air-extra-charges-and-products"], function() {
            Route::post('rt', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProductsRT']);
            Route::post('md', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProductMD']);
            Route::post('two-a', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProductTwoA']);
            Route::post('ow', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProductOW']);
        });

        Route::group(["prefix" => "cancel-booking"], function () {
            Route::post('commit', [CancelBookingController::class, 'cancelBookingCommit']);
            Route::post('viewonly', [CancelBookingController::class, 'cancelBookingViewOnly']);
            Route::post('cancelbooking-commit', [CancelBookingController::class, 'cancelBookingCommit']);
        });

        Route::group(["prefix" => "available-special-service"], function() {
            Route::post('two-a', [AvailableSpecialController::class, 'AvailableSpecialServiceTwoA']);
            Route::post('ow', [AvailableSpecialController::class, 'AvailableSpecialServiceOW']);
            Route::post('rt', [AvailableSpecialController::class, 'AvailableSpecialServiceRT']);
        });
        
        Route::post('/add-seat-ssr', [AddSeatController::class, 'addSeat']);
        Route::post('/add-weight-bag-ow', [AddWeightController::class, 'addWeight']);
        Route::post('/segment-base-available-services', [SegmentBaseController::class, 'segmentBaseAvailableSpecialServices']);
        Route::post('/seat-map', [SeatMapController::class, 'seatMap']);
        Route::post('/penalty-rules', [PenaltyRulesController::class, 'penaltyRules']);
        Route::post('/get-airport-matrix', [GetAirportMatrixController::class, 'GetAirportMatrix']);
        Route::post('/divide-pnr', [DividePNRController::class, 'dividePnR']);
    
    });
});

Route::group(["middleware" => ["auth:api"]], function () {    
    Route::group(["prefix" => 'user'], function() {
        Route::post('change/password', [RegisterController::class, 'changePassword']);
        Route::get('profile', [ProfileController::class, 'getProfile'] );
    });

    Route::post('/search-flights', [FlightController::class, 'searchFlights']);
    Route::get('/country', [CountryController::class, 'indexCountry']);
    Route::get('/city', [CityController::class, 'indexCity']);
    Route::get('/plane', [PlaneController::class, 'indexPlane']);
    Route::get('/airport', [AirportController::class, 'indexAirport']);
    Route::post('/passenger/tickets', [TicketController::class, 'storeMultipleTickets']);
    Route::post('/tickets/update-seats', [TicketController::class, 'updateSeats']);
    Route::get('/booking', [BookingController::class, 'getBooking']);

    Route::post('/paystack-checkout/pay', [PaystackPaymentController::class, 'initializePayment']);
    Route::get('/paystack-checkout/callback', [PaystackPaymentController::class, 'paymentCallback']);
    Route::post('payzeep/pay', [PayzeepPaymentController::class, 'initializePayment']);
    Route::post('payzeep/callback', [PayzeepPaymentController::class, 'paymentCallback']);
    Route::post('flutter-wave/pay', [FlutterwavePaymentController::class, 'initializePayment']);
    Route::post('flutter-wave/callback', [FlutterwavePaymentController::class, 'paymentCallback']);
    Route::get('booking-on-hold/{bookingId}', [BookingController::class, 'bookOnHold']);
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
