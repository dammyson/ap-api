<?php

namespace App\Http\Controllers;

use App\Http\Requests\Passenger\StorePassengersWithTicketsRequest;
use App\Http\Requests\Passenger\UpdatePassengersWithTicketsRequest;
use App\Services\Ticket\PassengerTicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $passengerTicketService;

    public function __construct(PassengerTicketService $passengerTicketService)
    {
        $this->passengerTicketService = $passengerTicketService;
    }

    public function storeMultipleTickets(StorePassengersWithTicketsRequest $request)
    {
        try {
            $message = $this->passengerTicketService->createPassengersWithTickets($request->input('passengers'));

            return response()->json($message, 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create passengers and tickets', 'error' => $e->getMessage()], 500);
        }
    }


    public function updateSeats(UpdatePassengersWithTicketsRequest $request){

        dd($request);

    }
}
