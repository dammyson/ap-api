<?php

namespace App\Http\Controllers\Soap;

use App\Models\Flight;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Events\UserActivityLogEvent;
use App\Exceptions\HititException;
use App\Http\Controllers\Controller;
use App\Services\Utility\CheckArray;
use App\Services\Utility\GetPointService;
use App\Services\Soap\TicketReservationRequestBuilder;
use App\Http\Controllers\Soap\Booking\BookingController;
use App\Http\Requests\Soap\Ticket\TicketReservationViewOnlyRequest;
use App\Models\Payment;

class TicketReservationController extends Controller
{

    protected $ticketReservationRequestBuilder;    
    protected $craneOTASoapService;
    protected $checkArray;
    protected $bookingController;
    protected $getPointService;

    public function __construct(TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray, BookingController $bookingController, GetPointService $getPointService)
    {
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->checkArray = $checkArray;
        $this->bookingController = $bookingController;
        $this->getPointService = $getPointService;
    }

    public function ticketReservationViewOnly(TicketReservationViewOnlyRequest $request) {
        $bookingId = $request->input('ID');
        $bookingReferenceId = $request->input('referenceID');
        $preferredCurrency = $request->input('preferred_currency');

        try {
    
            $function = 'http://impl.soap.ws.crane.hititcs.com/TicketReservation';            
    
            $xml = $this->ticketReservationRequestBuilder->ticketReservationViewOnly(
                $preferredCurrency,
                $bookingId,
                $bookingReferenceId
            );    
            
            $response = $this->craneOTASoapService->run($function, $xml);

            return $response;

            
            
        } catch (HititException $e) {
            Log::error('HITIT ERROR VIEWING TICKET RESERVATION', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);


            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
            ], 400);

        }  catch (\Throwable $th) {

            Log::error('ERROR VIEWING TICKET RESERVATION', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }

}
