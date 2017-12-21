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
        DB::table('personal_statistics')->insert([
            'year' => 2017,
            'month' => 12,
            'minutesOfDelay' => 666,
            'numberOfSevereDisruption' => 3,
            'user_id' => App\User::where('name', 'traveler1')->first()->id
        ]);
        DB::table('personal_statistics')->insert([
            'year' => 2017,
            'month' => 11,
            'minutesOfDelay' => 777,
            'numberOfSevereDisruption' => 10,
            'user_id' => App\User::where('name', 'traveler1')->first()->id
        ]);
    }
}
