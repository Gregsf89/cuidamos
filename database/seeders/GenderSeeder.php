<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gender::firstOrCreate(['id' => '1', 'name' => 'Male', 'initials' => 'M']);
        Gender::firstOrCreate(['id' => '2', 'name' => 'Female', 'initials' => 'F']);
        Gender::firstOrCreate(['id' => '3', 'name' => 'Other', 'initials' => 'O']);
    }
}
