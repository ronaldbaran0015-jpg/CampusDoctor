<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        DB::table('admins')->insert([
            [
                'adminname' => 'Administrator',
                'admincontact' => '09558032485',
                'adminusername' => 'admin',
                'adminpassword' => Hash::make('password'),
                'adminimage' => $faker->imageUrl,
            ],
        ]);
    }
}
