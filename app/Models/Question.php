<?php

namespace App\Models;

use Harishdurga\LaravelQuiz\Models\QuestionOption;
use Harishdurga\LaravelQuiz\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Harishdurga\LaravelQuiz\Models\Question as VendorQuestion;
use Illuminate\Database\Eloquent\Model;

class Question extends VendorQuestion
{
    use HasFactory;

    const SINGLE_SELECT = 1;
    const MULTIPLE_SELECT = 2;
    const FILL_THE_BLANKS = 3;

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function questionInfo()
    {
        return $this->hasOne(QuizQuestion::class);
    }
}
