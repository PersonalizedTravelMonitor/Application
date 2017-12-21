<?php

use Illuminate\Database\Seeder;

class PersonalStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trips')->insert([
            'year' => 2017,
            'month' => 12,
            'numberOfDisruption' => 3,
            'user_id' => App\User::where('name', 'traveler1')->first()->id
        ]);
        DB::table('trips')->insert([
            'year' => 2017,
            'month' => 11,
            'numberOfDisruption' => 5,
            'user_id' => App\User::where('name', 'traveler1')->first()->id
        ]);
    }
}
