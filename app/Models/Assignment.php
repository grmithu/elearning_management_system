<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function regularUpdate ()
    {
        return $this->hasOne(RegularUpdate::class, 'element_id')->where('element_type', get_class($this));
    }

    public function attempts ()
    {
        return $this->hasMany(AssignmentAttempt::class);
    }
}
