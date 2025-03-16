<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $students = [];

        // Generate 10 students for classroom_id = 13
        for ($i = 0; $i < 10; $i++) {
            $students[] = [
                'name' => $faker->name,
                'classroom_id' => 13,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'ambition' => $faker->optional()->word,
                'behaviour' => rand(0, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Generate 8 students for classroom_id = 19
        for ($i = 0; $i < 8; $i++) {
            $students[] = [
                'name' => $faker->name,
                'classroom_id' => 19,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'ambition' => $faker->optional()->word,
                'behaviour' => rand(0, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert into the database
        DB::table('students')->insert($students);
    }
}
