<?php

namespace App\Services\Ticket;

use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Ticket;
use App\Models\FlightTicketType;
use App\Services\Transaction\Transactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Invoice;
use Illuminate\Support\Str;

class PassengerTicketService
{
    protected $transactionService;

    public function __construct(Transactions $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    private function getTransactionTypeId($type)
    {
        $transactionTypes = [
            'flight_cost' => 1, // Example ID for flight cost
            'tax' => 2, // Example ID for tax
        ];

        return $transactionTypes[$type] ?? null;
    }
    public function createPassengersWithTickets(array $passengersData)
    {
        DB::beginTransaction();

        try {
            $createdTickets = [];
            $totalCost = 0;
            $user = auth()->user();


            // Create an invoice
            $invoice = Invoice::create([
                'number' => $this->generateInvoiceNumber(),
                'user_id' => $user->id, 
            ]);

            // Create a booking
            $booking = Booking::create([
                'booking_number' => $this->generateBookingNumber(),
                'last_name' => $user->last_name,
                'user_id' => $user->id,
                'invoice_id'=> $invoice->id,
            ]);


            foreach ($passengersData as $passengerData) {
                $passenger = Passenger::create([
                    'user_id' => auth()->user()->id,
                    'title' => $passengerData['title'],
                    'first_name' => $passengerData['first_name'],
                    'last_name' => $passengerData['last_name'],
                    'email' => $passengerData['email'],
                    'phone_number' => $passengerData['phone_number'],
                    'date_of_birth' => $passengerData['date_of_birth'],
                    'sex' => $passengerData['sex'],
                    'country' => $passengerData['country'],
                    'passport_number' => $passengerData['passport_number'],
                    'is_blind' => $passengerData['is_blind'],
                    'is_deaf' => $passengerData['is_deaf'],
                    'needs_mobility_assistance' => $passengerData['needs_mobility_assistance'],
                    'is_contact_person' => $passengerData['is_contact_person'],
                    'invoice_type' => $passengerData['invoice_type'],
                    'user_category' => $passengerData['user_category'],
                ]);

            
                foreach ($passengerData['tickets'] as $ticketData) {
                    $ticketType = FlightTicketType::
                       where('ticket_type_id', $ticketData['flight_ticket_type_id'])
                        ->where('flight_id', $ticketData['flight_id'])->firstOrFail();
                    // dd('I got here');

                    $ticket = Ticket::create([
                        'passenger_id' => $passenger->id,
                        'flight_id' => $ticketData['flight_id'],
                        'flight_ticket_type_id' => $ticketData['flight_ticket_type_id'],
                        'seat_number' => $ticketData['seat_number'],
                        'status' => $ticketData['status'],
                        'booking_id' => $booking->id
                    ]);

                    // Add to total cost
                    $totalCost += $ticketType->price;
                    // Decrement the available count of the ticket type

                    if ($ticketType) {
                        $ticketType->decrement('remain_seats');
                    }
                }
            }

            // Calculate total tax
            $totalTax = $totalCost * 0.05;

            // Create transactions for flight cost and tax
            $this->transactionService->createTransaction([
                'user_id' => auth()->user()->id, // Assuming all passengers are booked by the same user
                'invoice_id' => $invoice->id, // Assuming we use the first ticket ID as the invoice ID
                'transaction_type_id' => $this->getTransactionTypeId('flight_cost'), // Define how you get this ID
                'amount' => $totalCost,
                'description' => 'Total flight cost for booking',
                'is_flight' => true,
            ]);

            $this->transactionService->createTransaction([
                'user_id' => auth()->user()->id,
                'invoice_id' => $invoice->id,
                'transaction_type_id' => $this->getTransactionTypeId('tax'), // Define how you get this ID
                'amount' => $totalTax,
                'description' => 'Total tax for booking',
                'is_flight' => true,
            ]);

            DB::commit();

            return ['message' => 'Passengers and tickets created successfully'];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating passengers and tickets: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw $e; // Let the controller handle the exception
        }
    }

    private function generateBookingNumber()
    {
        return strtoupper(Str::random(6));
    }

    private function generateInvoiceNumber()
    {
        return strtoupper(Str::random(6) . Str::random(4, '0123456789')) . '-' . time();
    }
}
