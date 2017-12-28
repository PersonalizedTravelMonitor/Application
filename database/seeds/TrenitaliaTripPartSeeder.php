<?php

use Illuminate\Database\Seeder;

class TrenitaliaTripPartSeeder extends Seeder
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
        DB::table('trenitalia_trip_parts')->insert([
            'departure' => '16:05:00',
            'arrival' => '20:40:00',
            'trainId' => 'FR9578',
            'departurePlatform' => '5',
        ]);

        // then we create the generic trip parts
        DB::table('trip_parts')->insert([
            'trip_id' => 2, // bad idea for now, won't be necessary when we have a nice interface,
            'sequenceOrder' => 0,
            'from' => 'Roma Termini',
            'to' => 'Torino P.Nuova',
            'details_type' => 'App\TrenitaliaTripPart',
            'details_id' => 1, // same bad idea as above
        ]);
    }
}
