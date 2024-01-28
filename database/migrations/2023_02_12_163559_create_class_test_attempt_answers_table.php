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
        Schema::create('class_test_attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_test_attempt_id')->constrained('class_test_attempts')->nullable();
            $table->foreignId('class_test_question_id')->constrained('class_test_questions')->nullable();
            $table->longText('answer')->nullable();
            $table->float('obtained_mark')->nullable();
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
        Schema::dropIfExists('class_test_attempt_answers');
    }
};
