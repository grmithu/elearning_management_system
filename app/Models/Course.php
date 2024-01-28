<?php

namespace App\Models;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function enrollees ()
    {
        return $this->belongsToMany(User::class, 'course_enrollees', 'course_id', 'enrollee_id');
    }

    public function instructor ()
    {
        return $this->belongsTo(User::class);
    }

    public function department ()
    {
        return $this->belongsTo(Department::class);
    }

    public function detail ()
    {
        return $this->hasOne(CourseDetail::class);
    }

    public function resources ()
    {
        return $this->hasMany(CourseResource::class)->orderBy('id', 'DESC');
    }

    public function quizzes ()
    {
        return $this->hasMany(Quiz::class)->orderBy('id', 'DESC');
    }

    public function classTests ()
    {
        return $this->hasMany(ClassTest::class)->orderBy('id', 'DESC');
    }

    public function studentAttendances ()
    {
        return $this->hasMany(Attendance::class);
    }

    public function courseAttendances ()
    {
        return $this->hasMany(CourseAttendance::class);
    }

    public function regularUpdates ()
    {
        return $this->hasMany(RegularUpdate::class);
    }

    public function assignments ()
    {
        return $this->hasMany(Assignment::class)->where('is_presentation', false);
    }

    public function presentations ()
    {
        return $this->hasMany(Assignment::class)->where('is_presentation', true);
    }

    public function midtermMarks ()
    {
        return $this->hasMany(Midterm::class);
    }

    public function finalExamMarks ()
    {
        return $this->hasMany(FinalExam::class);
    }

    public function scopeCompletedPercentage ()
    {
        $increment = 100/4;
        $parcent = 0;

        if (count($this->classTests))
            $parcent +=$increment;

        if (count($this->assignments))
            $parcent +=$increment;

        if (count($this->midtermMarks))
            $parcent +=$increment;

        if (count($this->finalExamMarks))
            $parcent +=$increment;

        return $parcent;
    }
}
