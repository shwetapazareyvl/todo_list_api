<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        ]);

        //duration are provided in days
        DB::table('reminders')->insert([
            'title' => "reminder 1",
            'duration' => "1",
        ]);

        DB::table('reminders')->insert([
            'title' => "reminder 2",
            'duration' => "7",
        ]);
    }
}
