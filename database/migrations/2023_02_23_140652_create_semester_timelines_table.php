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
        Schema::create('semester_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('approximate_time')->nullable();
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
        Schema::dropIfExists('semester_timelines');
    }
};
