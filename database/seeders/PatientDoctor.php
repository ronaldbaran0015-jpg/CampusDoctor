<?php


// Database/Seeders/PatientDoctorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Specialties;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PatientDoctor extends Seeder
{
    public function run()
    {

        $faker = Faker::create();

        // --- Seed Patients ---
        for ($i = 0; $i < 10; $i++) {
            Patient::create([
                'name'         => $faker->name,
                'email'        => $faker->unique()->safeEmail,
                'password'     => Hash::make('password'), // default password
                'address'      => $faker->address,
                'dob'          => $faker->date('Y-m-d', '2005-01-01'),
                'contact'      => $faker->phoneNumber,
                'gender'       => $faker->randomElement(['Male', 'Female']),
                'relationship' => $faker->randomElement(['Single', 'Married', 'Widowed']),
                'image'        => null, // empty image field
            ]);
        }
       

        $specialties = [
            ['sname' => 'Cardiology', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'Neurology', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'Oncology', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'Pediatrics', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'Dermatology', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'Orthopedics', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'Gynecology', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'General Medicine', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'Ophthalmology', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['sname' => 'Psychiatry', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        Specialties::insert($specialties);
    }
}