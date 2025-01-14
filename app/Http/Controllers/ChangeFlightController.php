<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Models\InvoiceRecord;
use Illuminate\Support\Facades\DB;
use App\Services\Utility\CheckArray;
use App\Services\Soap\CancelBookingBuilder;
use App\Services\Soap\TicketReservationRequestBuilder;

class ChangeFlightController extends Controller
{
    //
    protected $cancelBookingBuilder;
    protected $ticketReservationRequestBuilder;
    protected $craneOTASoapService;
    protected $checkArray;
    

    public function __construct(CancelBookingBuilder $cancelBookingBuilder, TicketReservationRequestBuilder $ticketReservationRequestBuilder, CheckArray $checkArray)
    {
        $this->cancelBookingBuilder = $cancelBookingBuilder;
        $this->ticketReservationRequestBuilder = $ticketReservationRequestBuilder;
        $this->checkArray = $checkArray;
        $this->craneOTASoapService = app('CraneOTASoapService');
    }


}
