<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_details', 'semester_id', 'course_id');
    }

    public function timelines()
    {
        return $this->hasMany(SemesterTimeline::class);
    }
}
