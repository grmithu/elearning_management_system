<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTestAttempt extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function answers ()
    {
        return $this->hasMany(ClassTestAttemptAnswer::class);
    }

    public function participant ()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }
}
