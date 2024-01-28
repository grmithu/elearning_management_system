<?php

namespace Database\Seeders;

use App\Models\InstructorDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name'          => 'John Doe',
                'email'         => 'johndoe@cse.green.edu.bd',
                'username'      => 'johndoe',
                'type'          => 'instructor',
                'department_id' => 2,
                'password'      => bcrypt('123456')
            ],
        ]);

        InstructorDetail::insert([
            [
                'instructor_id' => 2,
                'office'        => 'GUB',
                'mobile'        => '12345678',
            ],
        ]);
    }
}
