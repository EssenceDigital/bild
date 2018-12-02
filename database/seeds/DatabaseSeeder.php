<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        "name"=> "Diana",
        "email"=> "diana@bildlethbridge.ca",
        "password"=> bcrypt(env('APP_ADMIN')),
        "role"=> "admin"
      ]);
    }
}
