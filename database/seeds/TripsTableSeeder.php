<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trips')->insert([
            'repeatingOn' => json_encode([Carbon::MONDAY, Carbon::TUESDAY]),
            'user_id' => App\User::where('name', 'traveler1')->first()->id
        ]);
        DB::table('trips')->insert([
            'repeatingOn' => json_encode([Carbon::SATURDAY, Carbon::SUNDAY]),
            'user_id' => App\User::where('name', 'traveler1')->first()->id
        ]);
    }
}
