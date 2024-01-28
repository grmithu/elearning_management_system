<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Semester::insert([
            [
                'name'          => 'Spring',
                'start_month'   => 1,
                'end_month'     => 4,
            ],
            [
                'name'          => 'Summer',
                'start_month'   => 5,
                'end_month'     => 8,
            ],
            [
                'name'          => 'Fall',
                'start_month'   => 9,
                'end_month'     => 12
            ],
        ]);
    }
}
