<?php

use Illuminate\Database\Seeder;

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
            'repeatingOn' => serialize([1,2,4]),
            'user_id' => App\User::where('name', 'admin')->first()->id,

        ]);
    }
}
