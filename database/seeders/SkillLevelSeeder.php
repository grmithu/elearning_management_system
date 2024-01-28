<?php

namespace Database\Seeders;

use App\Models\SkillLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SkillLevel::insert([
            [
                'name' => 'Beginner',
            ],
            [
                'name' => 'Intermediate',
            ],
            [
                'name' => 'Expert',
            ],
            [
                'name' => 'Professional',
            ],
        ]);
    }
}
