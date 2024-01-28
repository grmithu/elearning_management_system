<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function courses ()
    {
        return $this->hasMany(Course::class);
    }

    public function students ()
    {
        return $this->hasMany(User::class)
            ->where('type', 'student');
    }

    public function instructors ()
    {
        return $this->hasMany(User::class)
            ->where('type', 'instructor');
    }
}
