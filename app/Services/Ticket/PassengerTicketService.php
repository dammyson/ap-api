<?php

namespace App\Services\Ticket;

use App\Models\Passenger;
use App\Models\Ticket;
use App\Models\FlightTicketType;
use Illuminate\Support\Facades\DB;

class PassengerTicketService
{
    public function createPassengersWithTickets(array $passengersData)
    {
        DB::beginTransaction();

        try {
            $createdTickets = [];
            
            foreach ($passengersData as $passengerData) {
                $passenger = Passenger::create([
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
                    $ticket = Ticket::create([
                        'passenger_id' => $passenger->id,
                        'flight_id' => $ticketData['flight_id'],
                        'seat_number' => $ticketData['seat_number'],
                        'status' => $ticketData['status'],
                    ]);

                    // Decrement the available count of the ticket type
                    $ticketType = FlightTicketType::where('id', $ticketData['ticket_type_id'])
                    ->where('flight_id', $ticketData['flight_id'])->firstOrFail();
                    if ($ticketType) {
                        $ticketType->decrement('remain_seats');
                    }
                }
            }

            DB::commit();

            return ['message' => 'Passengers and tickets created successfully'];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Let the controller handle the exception
        }
    }
}