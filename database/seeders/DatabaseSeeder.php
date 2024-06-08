<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'user_name' => 'TestUser',
            'email' => 'test@example.com',
            'phone_number' => '08166219698',
            'peace_id' => 34,
            'password' => bcrypt('solomon001')
        ]);

           // Disable foreign key checks to avoid issues during seeding
                Schema::disableForeignKeyConstraints();

                // Truncate the tables before seeding to avoid duplicate entries
                DB::table('tickets')->truncate();
                DB::table('flight_ticket_types')->truncate();
                DB::table('flights')->truncate();
                DB::table('planes')->truncate();
                DB::table('airports')->truncate();
                DB::table('cities')->truncate();
                DB::table('countries')->truncate();
                DB::table('ticket_types')->truncate();
        
                // Seed countries
                $countryId = DB::table('countries')->insertGetId([
                    'name' => 'Nigeria',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        
                // Seed cities
                $lagosId = DB::table('cities')->insertGetId([
                    'name' => 'Lagos',
                    'country_id' => $countryId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        
                $abujaId = DB::table('cities')->insertGetId([
                    'name' => 'Abuja',
                    'country_id' => $countryId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        
                // Seed airports
                $lagosAirportId = DB::table('airports')->insertGetId([
                    'name' => 'LOS',
                    'city_id' => $lagosId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        
                $abujaAirportId = DB::table('airports')->insertGetId([
                    'name' => 'ABV',
                    'city_id' => $abujaId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
        
                // Seed planes
                $planes = [];
                $planeNames = ['Boeing 737', 'Airbus A320', 'Boeing 747', 'Airbus A380', 'Embraer E190', 'Boeing 787', 'Airbus A350', 'Bombardier CRJ900', 'Boeing 767', 'Airbus A330'];
                $planeCodes = ['B737', 'A320', 'B747', 'A380', 'E190', 'B787', 'A350', 'CRJ900', 'B767', 'A330'];
        
                for ($i = 0; $i < 20; $i++) {
                    $planes[] = [
                        'name' => $planeNames[$i % count($planeNames)],
                        'code' => $planeCodes[$i % count($planeCodes)] . '-' . ($i + 1),
                        'capacity' => rand(150, 300),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
        
                DB::table('planes')->insert($planes);
                $planeIds = DB::table('planes')->pluck('id')->toArray();
        
                // Seed ticket types
                DB::table('ticket_types')->insert([
                    [
                        'name' => 'Economy',
                        'description' => 'Economy class ticket with standard amenities.',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                    [
                        'name' => 'Business',
                        'description' => 'Business class ticket with extra legroom and premium services.',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                    [
                        'name' => 'First Class',
                        'description' => 'First class ticket with luxury amenities and personalized services.',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ],
                ]);
        
                $ticketTypes = DB::table('ticket_types')->get();
        
                // Define seat ratio
                $seatRatios = [
                    'Economy' => 7,
                    'Business' => 3,
                    'First Class' => 1,
                ];
        
                // Define ticket prices
                $ticketPrices = [
                    'Economy' => 100.00,
                    'Business' => 200.00,
                    'First Class' => 300.00,
                ];
        
                // Seed flights
                $startDate = Carbon::now();
                $flights = [];
        
                for ($day = 0; $day < 9; $day++) {
                    $currentDate = $startDate->copy()->addDays($day);
        
                    foreach ([$lagosAirportId, $abujaAirportId] as $originId) {
                        $destinationId = ($originId == $lagosAirportId) ? $abujaAirportId : $lagosAirportId;
        
                        // Create 5 departures
                        for ($i = 0; $i < 5; $i++) {
                            $departure = $currentDate->copy()->addMinutes(rand(0, 1439));
                            $arrival = $departure->copy()->addHours(rand(1, 6));
                            $planeId = $planeIds[array_rand($planeIds)];
                            $totalSeats = DB::table('planes')->where('id', $planeId)->value('capacity');
        
                            $flightId = DB::table('flights')->insertGetId([
                                'flight_number' => 'NG' . rand(1000, 9999),
                                'plane_id' => $planeId,
                                'origin_id' => $originId,
                                'destination_id' => $destinationId,
                                'departure' => $departure,
                                'arrival' => $arrival,
                                'status' => true,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
        
                            foreach ($seatRatios as $ticketType => $ratio) {
                                $type = $ticketTypes->firstWhere('name', $ticketType);
                                $seats = (int)($totalSeats * ($ratio / array_sum($seatRatios)));
        
                                DB::table('flight_ticket_types')->insert([
                                    'flight_id' => $flightId,
                                    'ticket_type_id' => $type->id,
                                    'price' => $ticketPrices[$ticketType],
                                    'seats' => $seats,
                                    'remain_seats' => $seats,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }
                        }
        
                        // Create 4 arrivals
                        for ($i = 0; $i < 4; $i++) {
                            $departure = $currentDate->copy()->addMinutes(rand(0, 1439));
                            $arrival = $departure->copy()->addHours(rand(1, 6));
                            $planeId = $planeIds[array_rand($planeIds)];
                            $totalSeats = DB::table('planes')->where('id', $planeId)->value('capacity');
        
                            $flightId = DB::table('flights')->insertGetId([
                                'flight_number' => 'NG' . rand(1000, 9999),
                                'plane_id' => $planeId,
                                'origin_id' => $destinationId,
                                'destination_id' => $originId,
                                'departure' => $departure,
                                'arrival' => $arrival,
                                'status' => true,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
        
                            foreach ($seatRatios as $ticketType => $ratio) {
                                $type = $ticketTypes->firstWhere('name', $ticketType);
                                $seats = (int)($totalSeats * ($ratio / array_sum($seatRatios)));
        
                                DB::table('flight_ticket_types')->insert([
                                    'flight_id' => $flightId,
                                    'ticket_type_id' => $type->id,
                                    'price' => $ticketPrices[$ticketType],
                                    'seats' => $seats,
                                    'remain_seats' => $seats,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now(),
                                ]);
                            }
                        }
                    }
                }
        
                // Enable foreign key checks
                Schema::enableForeignKeyConstraints();
        }
    
}
