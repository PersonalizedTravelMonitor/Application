<?php

use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // first we create the details for the event
        /*DB::table('traveler_report_events')->insert([
            'author_id' => 2,
            'message' => 'Train has stopped inside the tunnel'
        ]);

        DB::table('events')->insert([
            'trip_part_id' => 1, // the trip related to this event
            'severity' => 'INFO',
            'details_id' => '1',
            'details_type' => 'App\TravelerReportEvent'
        ]);*/
    }
}
