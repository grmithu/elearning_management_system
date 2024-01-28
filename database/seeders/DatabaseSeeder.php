<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Gallery;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $this->call
        ([
            DepartmentSeeder::class,
            AdminSeeder::class,
            InstructorSeeder::class,
            ProgramSeeder::class,
            FacultySeeder::class,
            SemesterSeeder::class,
//            SkillLevelSeeder::class,
            CourseSeeder::class,
            GallerySeeder::class,
            QuestionTypeSeeder::class
        ]);
    }
}
