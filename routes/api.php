<?php

use Psy\Sudo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TierController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PlaneController;

use App\Http\Controllers\FlightController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GamePlayController;
use App\Http\Controllers\GameRuleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserSurveyController;
use App\Http\Controllers\PaymentController;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Controllers\Admin\SurveyController;
use App\Http\Controllers\CancelFlightController;
use App\Http\Controllers\GameCategoryController;
use App\Http\Controllers\Soap\AddSeatController;
use App\Http\Controllers\Soap\SeatMapController;
use App\Http\Controllers\AnalyticsUserController;
use App\Http\Controllers\CreateBookingController;
use App\Http\Controllers\RedeemedRewardController;
use App\Http\Controllers\Soap\AddWeightController;
use App\Http\Controllers\Soap\DividePNRController;
use App\Http\Controllers\SharePeacePointController;
use App\Http\Controllers\Soap\ReissuePNRController;
use App\Http\Controllers\Soap\VoidTicketController;
use App\Http\Controllers\Admin\LoginAdminController;
use App\Http\Controllers\Guest\GuestLoginController;
use App\Http\Controllers\Soap\DivideDinerController;
use App\Http\Controllers\Soap\SegmentBaseController;
use App\Http\Controllers\Admin\ChangeAdminController;
use App\Http\Controllers\Soap\PenaltyRulesController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Soap\AddWeightControllerTest;
use App\Http\Controllers\Admin\CustomerAdminController;
use App\Http\Controllers\Admin\RegisterAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Soap\GetAvailabilityController;
use App\Http\Controllers\Soap\AvailableSpecialController;
use App\Http\Controllers\Soap\GetAirportMatrixController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Admin\ActivityLogAdminController;
use App\Http\Controllers\Admin\TeamMembersAdminController;
use App\Http\Controllers\RedeemTicketPeacePointController;
use App\Http\Controllers\Soap\TicketReservationController;
use App\Http\Controllers\Admin\ChangePasswordAdminController;
use App\Http\Controllers\Admin\ForgetPasswordAdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OnepipeController;
use App\Http\Controllers\Soap\Booking\CancelBookingController;
use App\Http\Controllers\Soap\Booking\BookingController;
use App\Http\Controllers\Soap\GetAirExtraChargesAndProductController;
use App\Http\Controllers\Soap\GetAirExtraChargesAndProductsController;
use App\Http\Middleware\LastLogin;

Route::group(["middleware" => ["throttle:global-rate-limiter"]], function () {        
    Route::post('guest/continue-as-guest', [GuestLoginController::class, 'continueAsGuest']);
});

Route::post("generate-virtual-account", [OnepipeController::class, 'generateVirtualAccount'])->middleware('auth:api');
Route::post("queryPaymentStatus", [OnepipeController::class, 'queryPaymentStatus'])->middleware('auth:api');

Route::group(['prefix' => 'user'], function ()  {
    Route::post('register', [RegisterController::class, 'userRegister']);
    Route::post('forgot-password', [RegisterController::class, 'forgotPassword']);
    Route::post('verify/otp', [RegisterController::class, 'verifyOtp']);
    Route::post('reset/password', [RegisterController::class, 'resetPassword']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('google-verify', [LoginController::class, 'googleVerify']);
});

Route::group(['prefix' => 'admin/'], function () {
    Route::post('admin-login', [LoginAdminController::class, 'loginAdmin']);
    Route::post('forgot-password', [ForgetPasswordAdminController::class, 'forgotPassword']);
    Route::post('verify/otp', [ForgetPasswordAdminController::class, 'verifyOtp']);
    Route::post('reset/password', [ForgetPasswordAdminController::class, 'resetPassword']);
    
    Route::middleware('auth:admin')->group(function () {  
        Route::post('admin-register', [RegisterAdminController::class, 'registerAdmin']);
  
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('weekly-analysis', [DashboardAdminController::class, 'weeklyAnalysis']);
            Route::get('revenue-graph/{filter}', [DashboardAdminController::class, 'revenueGraph']);
            Route::get('user-by-device', [DashboardAdminController::class, 'userByDevice']);
            Route::get('screen-resolution', [DashboardAdminController::class, 'screenResolution']);
            Route::get('total-registered-users-table', [DashboardAdminController::class, 'totalRegisteredUsersTable']);
            Route::get('total-purchased-tickets-table', [DashboardAdminController::class, 'totalPurchasedTicketTable']);
            Route::get('total-revenue-tickets-table', [DashboardAdminController::class, 'totalRevenueTicketTable']);
            Route::get('active-users-table', [DashboardAdminController::class, 'activeUserTable']);
            Route::get('recent-table', [DashboardAdminController::class, 'recentActivitiesTable']);
            
        });
        
        Route::group(['prefix' => 'customer'], function() {
            Route::get('customer-information', [CustomerAdminController::class, 'customerInformation']);
            Route::group(['prefix' => '{user}'], function() {
                Route::put('award-point-manually', [CustomerAdminController::class, 'awardPointManually']);
                Route::get('user-revenue/charts/{filter}', [CustomerAdminController::class, 'userRevenueChart']);
                Route::get('revenue-sources/charts', [CustomerAdminController::class, 'revenueCustomerChart']);
                Route::get('active-loyal-points', [CustomerAdminController::class, 'activeLoyalPoints']);
                Route::get('users-information', [CustomerAdminController::class, 'userInformation']);
                Route::get('total-loyal-points', [CustomerAdminController::class, 'totalLoyalPoint']);
                Route::get('total-flight-flown', [CustomerAdminController::class, 'totalFlightFlown']);
                Route::get('referrals', [CustomerAdminController::class, 'frequentFlyerMiles']);
                Route::get('revenue-sources', [CustomerAdminController::class, 'revenueSource']);
                Route::get('activity-log', [CustomerAdminController::class, 'activityLog']);
            });            
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
            // Route::get('/all-survey', [UserSurveyController::class, 'allSurvey']);
            Route::post('/survey-table', [SurveyController::class, 'surveyTable']);
            Route::group(['prefix' => '{survey}'], function () {
                Route::get('/', [SurveyController::class, 'showSurvey']);  
                Route::post('update-survey-image', [SurveyController::class, 'updateSurveyImage']);
                Route::patch('toogle-publish-survey', [SurveyController::class, 'tooglePublishSurvey']);
                // Route::patch('make-survey-false', [SurveyController::class, 'surveyFalse']);
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
            Route::patch('deactive-admin-account', [ProfileAdminController::class, 'deactivateAdminAccount']);
            Route::get('team-members', [TeamMembersAdminController::class, 'teamMembers']);
            Route::post('add-team-member', [RegisterAdminController::class, 'registerAdmin']);
            Route::delete('team-member/{teamMemberId}/delete', [TeamMembersAdminController::class , 'deleteTeamMembers']);
            Route::patch('profile/change-password', [ChangePasswordAdminController::class, 'ChangeAdminPassword']);
        });

        Route::post('featured-trip', [TripController::class, 'featuredTrip']);
        Route::post('special-deals', [TripController::class, 'specialDeals']);
        Route::post('favorite-cities-event', [TripController::class, 'favoriteCitiesEvent']);

        Route::post('admin-logout', [RegisterAdminController::class, 'logoutAdmin']);

        Route::post('game-categories', [GameCategoryController::class, 'store']);
        Route::post('games', [GameController::class, 'store']);

    });
});


Route::group(["middleware" => ["auth:api"], LastLogin::class], function() {
    Route::group(['prefix' => "soap/"], function () {
        Route::group(["prefix" => "void-ticket"], function() {
            Route::post('/pricing', [VoidTicketController::class, 'voidTicketPricing']);
            Route::post('/commit', [VoidTicketController::class, 'voidTicketCommit']);
        });

        Route::group(["prefix" => "ticket-reservation"], function() {
            Route::post('/view-only', [TicketReservationController::class, 'ticketReservationViewOnly']);

        });

        Route::group(["prefix" => "booking"], function() {
            Route::group(["prefix" => "retrieve"], function() {
                Route::post('retrieve-pnr-history', [BookingController::class, 'retrievePNRHistory']);
                Route::post('retrieve-ticket-history', [BookingController::class, 'retrieveTicketHistory']);
            });

            // Route::group(["prefix" => "read-booking"], function() {
            //     Route::post('read-booking-tk', [BookingController::class, 'readBookingTK']);
            //     Route::get('read-booking/{ID}/{referenceID}', [TicketReservationController::class, 'ticketReservationViewOnly']);
            //     Route::post('read-booking/surname', [BookingController::class, 'readBookingWithSurname']);
            //     Route::get('read-booking/{ID}/{referenceID}', [BookingController::class, 'readBooking']);
            // });

            Route::group(["prefix" => "read-booking"], function() {
                Route::post('tk', [BookingController::class, 'readBookingTk']);
                Route::post('surname', [BookingController::class, 'readBookingWithSurname']);

            });

            Route::group(["prefix" => "create-booking"], function() {
                Route::post('two-a', [CreateBookingController::class, 'createBooking']);
                Route::post('/', [CreateBookingController::class, 'createBooking']);
                Route::post('redeem-ticket-with-peace-point', [CreateBookingController::class, 'redeemTicketWithPeacePoint']);
                Route::post('verify-ticket-redemption-point', [CreateBookingController::class, 'verifyRedemptionPayment']);
            });

        });

        Route::group(['prefix' => 'surveys'], function() {
            Route::get('/', [UserSurveyController::class, 'indexSurvey']);   
            Route::post('/{survey}/fill-survey', [UserSurveyController::class, 'fillSurvey']);
           
        });
 
        Route::group(["prefix" => "get-availability"], function() {
            Route::post('general-parameters', [GetAvailabilityController::class, 'getAvailabilityGeneralParameters']);
            Route::post('get-availability-rt', [GetAvailabilityController::class, 'getAvailabilityRT']);
            Route::post('/', [GetAvailabilityController::class, 'getAvailabilityOW']);
            Route::post('get-availability-md', [GetAvailabilityController::class, 'getAvailabilityMD']);
            Route::post('get-availability-two-a', [GetAvailabilityController::class, 'getAvailabilityTwoA']);
        });

        
        Route::post('get-air-extra-charges-and-products', [GetAirExtraChargesAndProductsController::class, 'getAirExtraChargesAndProduct']);
       

        Route::group(['prefix' => 'reissue-ticket-pnr'], function() {
            Route::post('preview/{invoiceId}', [ReissuePNRController::class, 'reissueTicketPNR']);
            Route::post('commit', [ReissuePNRController::class, 'reissueTicketCommit']);
            Route::post('addFlightPreview', [ReissuePNRController::class, 'reissuePnrAddFlightPreview']);
            Route::post('addFlightCommit', [ReissuePNRController::class, 'reissuePnrAddFlightCommit']);
            Route::post('reissuePnrCancelFlightPreview', [ReissuePNRController::class, 'reissuePnrCancelFlightPreview']);
            Route::post('reissuePnrCancelFlightCommit', [ReissuePNRController::class, 'reissuePnrCancelFlightCommit']);
        });

        Route::group(["prefix" => "cancel-booking"], function () {
            Route::post('commit', [CancelBookingController::class, 'cancelBookingCommit']);
            Route::post('view-only', [CancelBookingController::class, 'cancelBookingViewOnly']);
        });

        Route::group(["prefix" => "available-special-service"], function() {
            Route::post('two-a', [AvailableSpecialController::class, 'AvailableSpecialServiceTwoA']);
            Route::post('ow', [AvailableSpecialController::class, 'AvailableSpecialServiceOW']);
            Route::post('rt', [AvailableSpecialController::class, 'AvailableSpecialServiceRT']);
        });
        
        Route::post('/add-weight-bag-ow/invoice/{invoiceId}/{ssrType}', [AddWeightController::class, 'addWeightOrInsurance']);
        Route::post('/select-seat', [AddSeatController::class, 'selectSeat']);
        
        Route::post('/segment-base-available-services', [SegmentBaseController::class, 'segmentBaseAvailableSpecialServices']);
        Route::post('/seat-map', [SeatMapController::class, 'seatMap']);
        Route::post('/penalty-rules', [PenaltyRulesController::class, 'penaltyRules']);
        Route::post('/get-airport-matrix', [GetAirportMatrixController::class, 'GetAirportMatrix']);
        Route::post('/divide-pnr', [DividePNRController::class, 'dividePnR']);
    });
});


Route::group(["middleware" => ["auth:api", "throttle:global-rate-limiter", LastLogin::class]], function () {    
    Route::group(["prefix" => 'user'], function() {
        Route::post('change/password', [RegisterController::class, 'changePassword']);
        Route::get('profile', [ProfileController::class, 'getProfile']);
        Route::get('allocate-points', [ProfileController::class, 'allocatePoint']);
        Route::post('profile/edit', [ProfileController::class, 'editProfile']);
        Route::post('profile/change-profile-image', [ProfileController::class, 'changeProfileImage']);
        Route::post('share-peace-point', [SharePeacePointController::class, 'sharePeacePoint']);
        Route::patch('test/increase-peace-point', [SharePeacePointController::class, 'increasePeacePoint']);
        Route::post('user-logout', [RegisterController::class, 'logoutUser']);
        Route::post('create-wallet', [WalletController::class, 'createWallet']);
        Route::get('trip-history', [AnalyticsUserController::class, 'tripHistory']);
        Route::get('upcoming-trips', [AnalyticsUserController::class, 'upcomingTrips']);
    });


    Route::prefix('verify-payment')->group(function () {
        Route::post('/ref', [PaymentController::class, 'verifyTicketRef']);
        Route::post('/tier-ref', [PaymentController::class, 'verifyTierRef']);
        // Route::post('/ref-quick-teller', [PaymentController::class, 'verifyQuickTeller']);
        Route::post('/ref-quick-teller', [OnepipeController::class, 'verifyQuickTeller']);
    });

    Route::post('/upgrade-tier', [TierController::class, 'upgradeTier']);
    
    Route::post('/search-flights', [FlightController::class, 'searchFlights']); 
    
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


Route::group(["middleware" => ["auth:api"], LastLogin::class], function () {

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

    Route::post('logout', [LoginController::class, 'logout']);
});

Route::prefix('notifications')->middleware('auth:api')->group(function () {
    Route::get('/', [NotificationController::class, 'listUserNotifications'])->name('notifications.list');
    Route::get('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/read-all', [NotificationController::class, 'markAllAsRead']) ->name('notifications.markAllAsRead');
});
