<?php

namespace App\Http\Controllers;

use App\Http\Requests\Passenger\StorePassengersWithTicketsRequest;
use App\Http\Requests\Passenger\UpdatePassengersWithTicketsRequest;
use App\Services\Ticket\PassengerTicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $passengerTicketService;

    
}
