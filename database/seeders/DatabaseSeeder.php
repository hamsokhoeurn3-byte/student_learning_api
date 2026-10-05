<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AcademicStructureSeeder::class,
            UserSeeder::class,
            CourseSeeder::class,
            LearningDataSeeder::class,
        ]);
    }
}