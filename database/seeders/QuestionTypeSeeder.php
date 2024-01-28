<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Harishdurga\LaravelQuiz\Models\QuestionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionTypes = [
            [
                'name'          => 'multiple_choice_single_answer',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'name'          => 'multiple_choice_multiple_answer',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
//            [
//                'name'          => 'fill_the_blank',
//                'created_at'    => Carbon::now(),
//                'updated_at'    => Carbon::now(),
//            ]
        ];

        QuestionType::insert($questionTypes);
    }
}
