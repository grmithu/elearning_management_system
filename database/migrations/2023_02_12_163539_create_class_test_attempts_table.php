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
        Schema::create('class_test_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_test_id')->constrained('class_tests')->nullable();
            $table->foreignId('participant_id')->constrained('users')->nullable();
            $table->foreignId('course_id')->constrained('courses')->nullable();
            $table->string('pdf')->nullable();
            $table->float('obtained_marks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_test_attempts');
    }
};
