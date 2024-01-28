<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')->constrained('courses');
            $table->string('course_code');
            $table->string('thumbnail')->default('default.jpg');
            $table->string('message')->nullable();
            $table->foreignId('program_id')->constrained('programs');
            $table->foreignId('faculty_id')->constrained('faculties');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->string('credit');
            $table->string('key', 800);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_details');
    }
};
