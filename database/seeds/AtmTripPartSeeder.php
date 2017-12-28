<?php

use Illuminate\Database\Seeder;

class AtmTripPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1 viaggio con 1 tratta

        // first we create the detailed parts
        DB::table('Atm_trip_parts')->insert([
            'line' => 'Linea 1 Rossa',
            'vehicleType' => 'Metro',
            'stopsNumber' => '4',
        ]);

        // then we create the generic trip parts
        DB::table('trip_parts')->insert([
            'trip_id' => 3, // bad idea for now, won't be necessary when we have a nice interface,
            'sequenceOrder' => 0,
            'from' => 'Milano Duomo',
            'to' => 'Milano Piola',
            'details_type' => 'App\AtmTripPart',
            'details_id' => 1, // same bad idea as above
        ]);
    }
}
