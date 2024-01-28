<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassTest extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function questions ()
    {
        return $this->hasMany(ClassTestQuestion::class);
    }

    public function attempts ()
    {
        return $this->hasMany(ClassTestAttempt::class);
    }

    public function regularUpdate ()
    {
        return $this->hasOne(RegularUpdate::class, 'element_id')->where('element_type', get_class($this));
    }
}
