<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Assuming specialties table has IDs from 1 to 10
        $specialtyIds = range(1, 10);

        foreach (range(1, 10) as $index) {
            DB::table('doctors')->insert([
                'name'     => $faker->name,
                'email'    => $faker->unique()->safeEmail,
                'contact'  => $faker->phoneNumber,
                'password' => Hash::make('password'), // hashed password
                'specialties' => $faker->randomElement($specialtyIds),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
