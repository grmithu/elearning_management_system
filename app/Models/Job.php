<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    const SKILL_LEVELS = [
        'Any',
        'Beginner',
        'Mid Level',
        'Experienced',
        'Top Level',
    ];

    const JOB_TYPES = [
        'Full Time',
        'Part Time',
        'Contractual',
        'Internship',
        'Freelance',
    ];

    public function jobRequirement()
    {
        return $this->hasOne(JobRequirement::class);
    }
}
