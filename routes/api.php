<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TierController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\RewardController;

use App\Http\Controllers\TicketController;
use App\Services\Soap\PenaltyRulesBuilder;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CountryController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GamePlayController;
use App\Http\Controllers\GameRuleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FillSurveyController;
use App\Http\Controllers\UserSurveyController;
use App\Http\Controllers\AddBaggagesController;
use App\Http\Controllers\TestPaymentController;
use App\Services\Soap\VoidTicketRequestBuilder;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\CancelFlightController;
use App\Http\Controllers\ChangeFlightController;
use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\Test\AddSeatController;
use App\Http\Controllers\Test\SeatMapController;
use App\Http\Controllers\CreateBookingController;
use App\Http\Controllers\RedeemedRewardController;
use App\Http\Controllers\Test\AddWeightController;
use App\Http\Controllers\Test\DividePNRController;
use App\Http\Controllers\SharePeacePointController;
use App\Http\Controllers\Test\TestWeightController;
use App\Http\Controllers\Test\VoidTicketController;
use App\Http\Controllers\Admin\LoginAdminController;
use App\Http\Controllers\Test\DivideDinerController;
use App\Http\Controllers\Test\SegmentBaseController;
use App\Http\Controllers\Admin\ChangeAdminController;
use App\Http\Controllers\Test\PenaltyRulesController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Admin\CustomerAdminController;
use App\Http\Controllers\Admin\RegisterAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Test\GetAvailabilityController;
use App\Http\Controllers\Test\AvailableSpecialController;
use App\Http\Controllers\Test\GetAirportMatrixController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Admin\ActivityLogAdminController;
use App\Http\Controllers\Admin\TeamMembersAdminController;
use App\Http\Controllers\Test\TicketReservationController;
use App\Http\Controllers\Admin\ChangePasswordAdminController;
use App\Http\Controllers\Admin\ForgetPasswordAdminController;
use App\Http\Controllers\AnalyticsUserController;
use App\Http\Controllers\RedeemTicketPeacePointController;
use App\Http\Controllers\Test\AddWeightControllerTest;
use App\Http\Controllers\Test\Booking\CancelBookingController;
use App\Http\Controllers\Test\Booking\BookingRequestController;
use App\Http\Controllers\Test\GetAirExtraChargesAndProductController;
use App\Http\Controllers\Test\GetAirExtraChargesAndProductsController;
use App\Http\Controllers\Test\ReissuePNRController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\WalletController;
use Psy\Sudo;

Route::get('/soap', [FlightController::class, 'callSoapApi']);
Route::post('test/get-airport-matrix', [GetAirportMatrixController::class, 'GetAirportMatrix']);
Route::post('/search-flights', [FlightController::class, 'searchFlightsTwo']);
Route::post('test-two-a', [CreateBookingController::class, 'createBookingTwo']);


Route::group(['prefix' => 'user'], function ()  {
    Route::post('register', [RegisterController::class, 'userRegister']);
    Route::post('forgot-password', [RegisterController::class, 'forgotPassword']);
    Route::post('verify/otp', [RegisterController::class, 'verifyOtp']);
    Route::post('reset/password', [RegisterController::class, 'resetPassword']);
    Route::post('login', [LoginController::class, 'login']);
});


Route::post('/upgrade-tier', [TierController::class, 'upgradeTier'])->middleware('auth');

Route::group(['prefix' => 'admin/'], function () {
    Route::post('admin-register', [RegisterAdminController::class, 'registerAdmin']);
    Route::post('admin-login', [LoginAdminController::class, 'loginAdmin']);
    Route::post('forgot-password', [ForgetPasswordAdminController::class, 'forgotPassword']);
    Route::post('verify/otp', [ForgetPasswordAdminController::class, 'verifyOtp']);
    Route::post('reset/password', [ForgetPasswordAdminController::class, 'resetPassword']);
    
    Route::middleware('auth:admin')->group(function () {    
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('weekly-analysis', [DashboardAdminController::class, 'weeklyAnalysis']);
            Route::get('revenue-graph/{filter}', [DashboardAdminController::class, 'revenueGraph']);
            Route::get('user-by-device', [DashboardAdminController::class, 'userByDevice']);
            Route::get('screen-resolution', [DashboardAdminController::class, 'screenResolution']);
            Route::get('total-registered-users-table', [DashboardAdminController::class, 'totalRegisteredUsersTable']);
            Route::get('total-purchased-tickets-table', [DashboardAdminController::class, 'totalPurchasedTicketTable']);
            Route::get('active-users-table', [DashboardAdminController::class, 'activeUserTable']);
            
        });

        Route::group(['prefix' => 'customer'], function() {
            Route::get('customer-information', [CustomerAdminController::class, 'customerInformation']);
            Route::put('award-point-manually/{user}', [CustomerAdminController::class, 'awardPointManually']);
            Route::get('revenue-sources/charts/{user}', [CustomerAdminController::class, 'revenueCustomerChart']);
            Route::get('active-loyal-points', [CustomerAdminController::class, 'activeLoyalPoints']);
            Route::get('total-loyal-points', [CustomerAdminController::class, 'totalLoyalPoint']);
            Route::get('total-flight-flown', [CustomerAdminController::class, 'totalFlightFlown']);
            Route::get('referrals', [CustomerAdminController::class, 'frequentFlyerMiles']);
            Route::get('revenue-sources', [CustomerAdminController::class, 'revenueSource']);
            Route::get('activity-log', [CustomerAdminController::class, 'activityLog']);

        });

        Route::group(['prefix' => 'activity-log'], function() {
            Route::post('create-activity-log', [ActivityLogAdminController::class, 'storeActivityLog']);
            Route::get('activity-log-table-data', [ActivityLogAdminController::class, 'indexActivityLog']);
            Route::post('filter-activity-log', [ActivityLogAdminController::class, 'filterActivityLog']);
        });

        Route::group(['prefix' => 'surveys'], function () {
            Route::post('create-survey', [SurveyController::class, 'createSurvey']);
            Route::patch('deactivate-survey', [SurveyController::class, 'deActiveSurvey']);
            Route::post('create-survey-banner', [SurveyController::class, 'createSurveyBanner']);            
            Route::get('/', [UserSurveyController::class, 'indexSurvey']);
            Route::post('/survey-table', [SurveyController::class, 'surveyTable']);
            Route::group(['prefix' => '{survey}'], function () {
                Route::get('/', [SurveyController::class, 'showSurvey']);  
                Route::post('update-survey-image', [SurveyController::class, 'updateSurveyImage']);
                Route::patch('toogle-publish-survey', [SurveyController::class, 'tooglePublishSurvey']);
                Route::put('edit', [SurveyController::class, 'editSurvey']);                
                Route::delete('delete', [SurveyController::class, 'deleteSurvey']);
                Route::get('participants', [SurveyController::class, 'surveyParticipants']);
                Route::get('survey-result', [SurveyController::class, 'getSurveyResults']);
                Route::get('survey-result-gender', [SurveyController::class, 'getSurveyResultByGender']);
                Route::put('allocate-points/{participant_id}', [SurveyController::class, 'allocatePointToParticipant']);
                Route::delete('delete', [SurveyController::class, 'deleteSurvey']);
                Route::delete('questions/{question}', [SurveyController::class, 'deleteQuestion']);
                Route::delete('questions/{question}', [SurveyController::class, 'deleteQuestion']);
                Route::delete('questions/{question}/options/{option}', [SurveyController::class, 'deleteOption']);

                /*
                Route::group(['prefix' => 'questions'], function () { 
                    Route::group(['prefix' => '{question}'], function () {  
                        Route::delete('delete', [SurveyController::class, 'deleteQuestion']);
                        
                        Route::group(['prefix' => 'options'], function () {
                            Route::delete('{option}/delete', [SurveyController::class, 'deleteOption']);
                        });

                    });
                });
                */
                
        
            });
        });

        Route::group(['prefix' => 'settings'], function () {
            Route::get('profile', [ProfileAdminController::class, 'getAdminProfile']);
            Route::put('profile/edit', [ProfileAdminController::class, 'editAdminProfile']);
            Route::post('profile/change-profile-image', [ProfileAdminController::class, 'changeAdminProfileImage']);
            Route::patch('change-admin-role', [ProfileAdminController::class, 'changeAdminRole']);
            Route::delete('delete-admin-account', [ProfileAdminController::class, 'deleteAdmin']);
            Route::get('team-members', [TeamMembersAdminController::class, 'teamMembers']);
            Route::post('add-team-member', [RegisterAdminController::class, 'registerAdmin']);
            Route::delete('team-member/{teamMemberId}/delete', [TeamMembersAdminController::class , 'deleteTeamMembers']);
            Route::patch('profile/change-password', [ChangePasswordAdminController::class, 'ChangeAdminPassword']);
        });

        Route::post('featured-trip', [TripController::class, 'featuredTrip']);
        Route::post('special-deals', [TripController::class, 'specialDeals']);
        Route::post('favorite-cities-event', [TripController::class, 'favoriteCitiesEvent']);

        Route::post('admin-logout', [RegisterAdminController::class, 'logoutAdmin']);


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
            Route::post('/commit/invoice/{invoiceId}', [TicketReservationController::class, 'ticketReservationCommit']);
            Route::post('/commit-test', [TicketReservationController::class, 'testTicketReservationCommit']);
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

            Route::group(["prefix" => "read-user-booking"], function() {
                Route::post('read-user-booking-tk', [BookingRequestController::class, 'readUserBookingTk']);
            });

            Route::group(["prefix" => "create-booking"], function() {
                Route::post('rt', [CreateBookingController::class, 'createBookingRT']);
                Route::post('ow', [CreateBookingController::class, 'createBookingOW']);
                Route::post('two-a', [CreateBookingController::class, 'createBookingTwoA']);
                Route::post('test-two-a', [CreateBookingController::class, 'createBookingTwo']);
            });

        });

        Route::group(['prefix' => 'surveys'], function() {
            Route::get('/', [UserSurveyController::class, 'indexSurvey']);   
            Route::post('/{survey}/fill-survey', [UserSurveyController::class, 'fillSurvey']);
           
        });
 
        Route::group(["prefix" => "get-availability"], function() {
            Route::post('general-parameters', [GetAvailabilityController::class, 'getAvailabilityGeneralParameters']);
            Route::post('get-availability-rt', [GetAvailabilityController::class, 'getAvailabilityRT']);
            Route::post('get-availability-ow', [GetAvailabilityController::class, 'getAvailabilityOW']);
            Route::post('get-availability-md', [GetAvailabilityController::class, 'getAvailabilityMD']);
            Route::post('get-availability-two-a', [GetAvailabilityController::class, 'getAvailabilityTwoA']);
        });

        Route::group(["prefix" => "get-air-extra-charges-and-products"], function() {
            Route::post('rt', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProductRT']);
            Route::post('md', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProductMD']);
            Route::post('two-a', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProductTwoA']);
            Route::post('ow', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProductOW']);
        });

        Route::group(['prefix' => 'reissue-ticket-pnr'], function() {
            Route::post('preview', [ReissuePNRController::class, 'reissueTicketPNR']);
            Route::post('commit', [ReissuePNRController::class, 'reissueTicketCommit']);
            Route::post('addFlightPreview', [ReissuePNRController::class, 'reissuePnrAddFlightPreview']);
            Route::post('addFlightCommit', [ReissuePNRController::class, 'reissuePnrAddFlightCommit']);
            Route::post('reissuePnrCancelFlightPreview', [ReissuePNRController::class, 'reissuePnrCancelFlightPreview']);
            Route::post('reissuePnrCancelFlightCommit', [ReissuePNRController::class, 'reissuePnrCancelFlightCommit']);
        });

        Route::group(["prefix" => "cancel-booking"], function () {
            Route::post('commit', [CancelBookingController::class, 'cancelBookingCommit']);
            Route::post('view-only', [CancelBookingController::class, 'cancelBookingViewOnly']);
            Route::post('cancel-booking-commit', [CancelBookingController::class, 'cancelBookingCommit']);
        });

        Route::group(["prefix" => "available-special-service"], function() {
            Route::post('two-a', [AvailableSpecialController::class, 'AvailableSpecialServiceTwoA']);
            Route::post('ow', [AvailableSpecialController::class, 'AvailableSpecialServiceOW']);
            Route::post('rt', [AvailableSpecialController::class, 'AvailableSpecialServiceRT']);
        });
        
        Route::post('/add-seat-ssr', [AddSeatController::class, 'addSeat']);
        Route::post('/add-weight-bag-ow/invoice-test/{invoiceId}', [AddWeightControllerTest::class, 'addWeightTest']);
        Route::post('/add-weight-bag-ow/invoice/{invoiceId}', [AddWeightController::class, 'addWeight']);
        Route::post('/select-seat', [AddWeightController::class, 'selectSeat']);
        
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
        Route::get('profile', [ProfileController::class, 'getProfile']);
        Route::post('profile/edit', [ProfileController::class, 'editProfile']);
        Route::post('profile/change-profile-image', [ProfileController::class, 'changeProfileImage']);
        Route::post('share-peace-point', [SharePeacePointController::class, 'sharePeacePoint']);
        Route::patch('test/increase-peace-point', [SharePeacePointController::class, 'increasePeacePoint']);
        Route::post('user-logout', [RegisterController::class, 'logoutUser']);
        Route::post('create-wallet', [WalletController::class, 'createWallet']);
        Route::get('trip-history', [AnalyticsUserController::class, 'tripHistory']);
    });


    
    Route::prefix('verify-payment')->group(function () {
        Route::post('/ref', [TestPaymentController::class, 'verify'])->name('wallet.top_up');
    });

    Route::post('redeem-ticket-with-peace-point', [RedeemTicketPeacePointController::class, 'payWithPeacePoint']);


    Route::post('cancel-flight-view-only', [CancelFlightController::class, 'cancelFlightViewOnly']);
    Route::post('cancel-flight-commit', [CancelFlightController::class, 'cancelFlightCommit']);
    Route::post('change-flight', [ChangeFlightController::class, 'changeFlight']);
    Route::post('change-flight-view-only', [ChangeFlightController::class, 'changeFlightViewOnly']);
    
    Route::post('/search-flight-two', [FlightController::class, 'searchFlightsTwo']);
    Route::post('/search-flights', [FlightController::class, 'searchFlights']);
    Route::get('/country', [CountryController::class, 'indexCountry']);
    Route::get('/city', [CityController::class, 'indexCity']);
    Route::get('/plane', [PlaneController::class, 'indexPlane']);
    Route::get('/airport', [AirportController::class, 'indexAirport']);
    Route::post('/passenger/tickets', [TicketController::class, 'storeMultipleTickets']);
    Route::post('/tickets/update-seats', [TicketController::class, 'updateSeats']);
    Route::get('/booking', [BookingController::class, 'getBooking']);
 
    
    // Analytics
    Route::group(['prefix' => 'analytics'], function() { // 
        Route::get('total-flight', [AnalyticsUserController::class, 'totalFlight']);
        Route::get('total-referrals', [AnalyticsUserController::class, 'totalReferral']);
        Route::get('number-of-countries-visited', [AnalyticsUserController::class, 'countriesVisited']);
        Route::get('total-mile-flown', [AnalyticsUserController::class, 'totalMileFlown']);
        Route::get('countries-and-cities-charts', [AnalyticsUserController::class, 'countriesAndCityChart']);
        // Route::get('delete', [AnalyticsUserController::class, 'deleteFlight']); //135;
        // Route::get('totalMileFlown')
        
        
        // travel recommendation
        Route::get('travel-pattern', [TripController::class, 'travelPattern']);
        Route::get('featured-trip', [TripController::class, 'featuredTrip']);
        Route::get('special-deals', [TripController::class, 'specialDeals']);
        Route::get('favorite-cities-event', [TripController::class, 'favoriteCitiesEvent']);
        Route::get('busiest-month', [TripController::class, 'busiestMonth']);
        Route::get('average-flight-duration', [TripController::class, 'averageFlightDuration']);
        Route::get('list-countries', [TripController::class, 'listCountries']);
    });
    
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
    Route::get('game-leaderboard', [GamePlayController::class, 'gameLeaderboard']);
    Route::get('overall-game-leaderboard', [GamePlayController::class, 'overallLeaderboard']);

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
