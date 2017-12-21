<?php

use Illuminate\Database\Seeder;

class TrenordTripPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      

        // these 4 calls will create a two part trip from Sondrio to Milano Greco Pirelli

        // first we create the detailed parts
        DB::table('trenord_trip_parts')->insert([
            'departure' => '7:07:00',
            'arrival' => '8:16:00',
            'trainId' => 'diretto',
            'line' => 'Milano-Lecco-Sondrio',
        ]);

        DB::table('trenord_trip_parts')->insert([
            'departure' => '8:20:00',
            'arrival' => '8:29:00',
            'trainId' => 'regionale',
            'line' => 'Milano-Lecco-Sondrio',
        ]);

        // then we create the generic trip parts
        DB::table('trip_parts')->insert([
            'trip_id' => 1, // bad idea for now, won't be necessary when we have a nice interface,
            'sequenceOrder' => 0,
            'from' => 'Sondrio',
            'to' => 'Monza',
            'child_type' => 'TrenordTripPart',
            'child_id' => 1, // same bad idea as above
        ]);

        DB::table('trip_parts')->insert([
            'trip_id' => 1, // bad idea for now, won't be necessary when we have a nice interface
            'sequenceOrder' => 1,
            'from' => 'Monza',
            'to' => 'Milano Greco Pirelli',
            'child_type' => 'TrenordTripPart',
            'child_id' => 2, // same bad idea as above
        ]);
    }
}
