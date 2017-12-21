<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'traveler1',
            'email' => 'traveler1@ptm.com',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@ptm.com',
            'password' => bcrypt('password'),
            'isAdmin' => true,
        ]);
        //
    }
}
