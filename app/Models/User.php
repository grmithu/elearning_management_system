<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses ()
    {
        return $this->hasMany(Course::class, 'instructor_id', 'id');
    }

    public function detail ()
    {
        return $this->hasOne(InstructorDetail::class, 'instructor_id');
    }

    public function department ()
    {
        return $this->belongsTo(Department::class);
    }

    public function enrolledCourses ()
    {
        return $this->belongsToMany(Course::class, 'course_enrollees', 'enrollee_id', 'course_id');
    }

    public function todayAttendance ()
    {
        return $this->hasOne(Attendance::class, 'student_id')->whereDate('date_time', today());
    }

    public function todoList ()
    {
        return $this->hasOne(TodoList::class);
    }

    public function midtermMarks ()
    {
        return $this->hasMany(Midterm::class, 'participant_id');
    }

    public function finalExamMarks ()
    {
        return $this->hasMany(FinalExam::class, 'participant_id');
    }
}
