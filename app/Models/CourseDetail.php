<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    public function program ()
    {
        return $this->belongsTo(Program::class);
    }
    public function faculty ()
    {
        return $this->belongsTo(Faculty::class);
    }
    public function semester ()
    {
        return $this->belongsTo(Semester::class);
    }
    public function skill_level ()
    {
        return $this->belongsTo(SkillLevel::class);
    }
}
