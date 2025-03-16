<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classroomNames = ['Amanah', 'Bestari', 'Cerdas', 'Gigih'];

        for ($year = 1; $year <= 6; $year++) {
            foreach ($classroomNames as $name) {
                DB::table('classrooms')->insert([
                    'name' => $name,
                    'year' => $year,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
