<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Harishdurga\LaravelQuiz\Models\Quiz as VendorQuiz;
use Illuminate\Database\Eloquent\Model;

class Quiz extends VendorQuiz
{
    use HasFactory;

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_questions', 'quiz_id', 'question_id');
    }

    public static function newFactory()
    {
        return parent::newFactory();
    }

    public function regularUpdate ()
    {
        return $this->hasOne(RegularUpdate::class, 'element_id')->where('element_type', get_class($this));
    }
}
