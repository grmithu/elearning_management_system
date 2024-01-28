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
        Schema::create('midterms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('users')->nullable();
            $table->foreignId('course_id')->constrained('courses')->nullable();
            $table->boolean('is_present')->default(true);
            $table->float('obtained_marks')->nullable();
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
        Schema::dropIfExists('midterms');
    }
};
