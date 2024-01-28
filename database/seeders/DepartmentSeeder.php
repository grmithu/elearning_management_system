<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::insert([
            [
                'name' => 'EEE',
                'thumbnail' => 'eee1.jpg',
            ],
            [
                'name' => 'CSE',
                'thumbnail' => 'cse1.jpg',
            ],
            [
                'name' => 'BBA',
                'thumbnail' => 'bba1.jpg',
            ],
            [
                'name' => 'English',
                'thumbnail' => 'english1.jpg',
            ],
        ]);
    }
}
