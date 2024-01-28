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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_title')->nullable();
            $table->string('skill_level')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_logo')->default('default.png');
            $table->string('job_type')->nullable();
            $table->string('location')->nullable();
            $table->string('job_industry')->nullable();
            $table->string('total_vacancy')->nullable();
            $table->string('basic_salary')->nullable();
            $table->longText('benefits')->nullable();
            $table->date('deadline')->nullable();
            $table->string('apply_url')->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('jobs');
    }
};
