<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\CourseDetail;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::insert([
            [
                'title'         => 'Electrical Properties of Materials (Spring 2023)',
                'description'   => 'Electrical Properties of Materials (Spring 2023)',
                'instructor_id' => 2,
                'department_id' => 1,
            ],
            [
                'title'         => 'Aplied Epidemiology',
                'description'   => 'Aplied Epidemiology',
                'instructor_id' => 2,
                'department_id' => 1,
            ],
            [
                'title'         => 'Economics and Accounting for Engineers (Spring 2023)',
                'description'   => 'Economics and Accounting for Engineers (Spring 2023)',
                'instructor_id' => 2,
                'department_id' => 3,
            ],
            [
                'title'         => 'Data Communication [Spring 2023]',
                'description'   => 'Data Communication [Spring 2023]',
                'instructor_id' => 2,
                'department_id' => 2,
            ],
        ]);

        CourseDetail::insert([
            [
                'course_id'         => 1,
                'course_code'       => 'EPMF2022',
                'thumbnail'         => 'course1.png',
                'message'           => 'Hello Dear !',
                'program_id'        => 1,
                'faculty_id'        => 1,
                'semester_id'       => 1,
                'credit'            => 3,
                'key'               => Str::random(32),
            ],
            [
                'course_id'         => 2,
                'course_code'       => 'AEW2021',
                'thumbnail'         => 'course2.png',
                'message'           => 'Hello Dear !',
                'program_id'        => 1,
                'faculty_id'        => 1,
                'semester_id'       => 1,
                'credit'            => 4,
                'key'               => Str::random(32),
            ],
            [
                'course_id'         => 3,
                'course_code'       => 'EAES2021',
                'thumbnail'         => 'course3.jpg',
                'message'           => 'Hello Dear !',
                'program_id'        => 1,
                'faculty_id'        => 1,
                'semester_id'       => 1,
                'credit'            => 2,
                'key'               => Str::random(32),
            ],
            [
                'course_id'         => 4,
                'course_code'       => 'DCS2021',
                'thumbnail'         => 'course4.png',
                'message'           => 'Hello Dear !',
                'program_id'        => 1,
                'faculty_id'        => 1,
                'semester_id'       => 1,
                'credit'            => 3,
                'key'               => Str::random(32),
            ],
        ]);
    }
}
