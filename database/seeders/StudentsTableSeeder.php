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
        $usedIcs = [];

        // Function to generate unique 12-digit IC
        function generateUniqueIc(&$usedIcs)
        {
            do {
                $ic = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
            } while (in_array($ic, $usedIcs));

            $usedIcs[] = $ic;
            return $ic;
        }

        // Generate 10 students for classroom_id = 13
        for ($i = 0; $i < 10; $i++) {
            $students[] = [
                'name' => $faker->name,
                'ic' => generateUniqueIc($usedIcs),
                'classroom_id' => 13,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'ambition' => $faker->optional()->word,
                'behaviour' => rand(1, 60),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Generate 8 students for classroom_id = 19
        for ($i = 0; $i < 8; $i++) {
            $students[] = [
                'name' => $faker->name,
                'ic' => generateUniqueIc($usedIcs),
                'classroom_id' => 19,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'ambition' => $faker->optional()->word,
                'behaviour' => rand(1, 60),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert into the database
        DB::table('students')->insert($students);
    }
}
