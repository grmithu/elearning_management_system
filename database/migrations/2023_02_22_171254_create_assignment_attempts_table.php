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
        Schema::create('assignment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->nullable();
            $table->foreignId('participant_id')->constrained('users')->nullable();
            $table->foreignId('course_id')->constrained('courses')->nullable();
            $table->string('pdf')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('assignment_attempts');
    }
};
