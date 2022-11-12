<?php

namespace Database\Seeders;

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
        $seeders = [
            StateSeeder::class,
            CitySeeder::class,
            GenderSeeder::class,
        ];

        $this->call($seeders);
    }
}
