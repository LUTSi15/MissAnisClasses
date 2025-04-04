<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(ClassroomSeeder::class);
        // $this->call(StudentsTableSeeder::class);

        User::factory()->create([
            'name' => 'Anis Zaini',
            'email' => 'anis@gmail.com',
            'password' => 'anis1234',
        ]);
    }
}
