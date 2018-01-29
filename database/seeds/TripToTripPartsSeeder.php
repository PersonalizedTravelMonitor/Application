<?php

use Illuminate\Database\Seeder;

class TripToTripPartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Trenord
        /*DB::Table('trips_to_trip_parts')->insert([
        	'trip_id'=> 1, // Viaggio 1 di traveller 1
        	'trip_part_id' =>1 // 707 da lecco a Monza
        ]);

        DB::Table('trips_to_trip_parts')->insert([
        	'trip_id'=> 1, // Viaggio 1 di traveller 1
        	'trip_part_id' =>2 // boh da Monza a Greco
        ]);

        // Trenitalia
        DB::Table('trips_to_trip_parts')->insert([
        	'trip_id'=> 2, // roma termini
        	'trip_part_id' =>3 //
        ]);

        DB::Table('trips_to_trip_parts')->insert([
        	'trip_id'=> 2, // roma termini
        	'trip_part_id' =>2 // a roma termini aggiungo monza-greco
        ]);

        // ATM
        DB::Table('trips_to_trip_parts')->insert([
        	'trip_id'=> 3,
        	'trip_part_id' =>4
        ]);*/
    }
}
