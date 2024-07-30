<?php

namespace App\Http\Controllers;

use App\Http\Requests\Passenger\SearchFlightRequest;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\FlightTicketType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FlightController extends Controller
{
    /**
     * Search for flights based on provided criteria.
     */
    public function searchFlights(SearchFlightRequest $request)
    {
        $departureDate = Carbon::parse($request->input('departure_date'));
        $arrivalDate = Carbon::parse($request->input('arrival_date'));
        $passengers = $request->input('passengers');
        $roundTrip = $request->input('round_trip');
        $departureAirportName = $request->input('departure_airport');
        $arrivalAirportName = $request->input('arrival_airport');

        // Lookup airport IDs based on names
        $departureAirport = Airport::where('name', $departureAirportName)->first();
        $arrivalAirport = Airport::where('name', $arrivalAirportName)->first();

        if (!$departureAirport || !$arrivalAirport) {
            return response()->json(['error' => 'Invalid airport name provided'], 400);
        }

        // Search for available flights
        $oneWayFlights = Flight::where('departure', '>=', $departureDate)
            ->where('arrival', '<=', $arrivalDate)
            ->where('origin_id', $departureAirport->id)
            ->where('destination_id', $arrivalAirport->id)
            ->where('status', true)
            ->with(['ticketTypes' => function ($query) use ($passengers) {
                $query->where('remain_seats', '>=', $passengers);
            }])
            ->orderBy('departure')
            ->get()
            ->filter(function ($flight) {
                return $flight->ticketTypes->isNotEmpty();
            })
            ->groupBy(function ($flight) {
                return Carbon::parse($flight->departure)->format('Y-m-d');
            })
            ->sortKeysDesc();

        $response = [
            'one_way_flights' => $oneWayFlights
        ];

        if ($roundTrip) {
            // Search for return flights
            $returnFlights = Flight::where('departure', '>=', $arrivalDate)
                ->where('origin_id', $arrivalAirport->id)
                ->where('destination_id', $departureAirport->id)
                ->where('status', true)
                ->with(['ticketTypes' => function ($query) use ($passengers) {
                    $query->where('remain_seats', '>=', $passengers);
                }])
                ->orderBy('departure')
                ->get()
                ->filter(function ($flight) {
                    return $flight->ticketTypes->isNotEmpty();
                })
                ->groupBy(function ($flight) {
                    return Carbon::parse($flight->departure)->format('Y-m-d');
                })
                ->sortKeysDesc();

            $response['return_flights'] = $returnFlights;
        }

        return response()->json($response);
    }
}
