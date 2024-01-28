<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('course_enrollees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses');
            $table->foreignId('enrollee_id')->constrained('users');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('course_enrollees');
    }
};
