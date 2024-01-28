<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->float('total_marks')->nullable();
            $table->float('pass_marks')->nullable();
            $table->boolean('is_published')->default(true);
            $table->string('media_url')->default('default.jpg');
            $table->string('duration')->default(0);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_upto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_tests');
    }
};
