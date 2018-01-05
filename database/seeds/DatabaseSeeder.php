<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PersonalStatisticSeeder::class);

        $this->call(TripsTableSeeder::class);
        $this->call(TrenordTripPartSeeder::class);
        $this->call(TrenitaliaTripPartSeeder::class);
        $this->call(AtmTripPartSeeder::class);

        $this->call(EventsSeeder::class);

    }
}
