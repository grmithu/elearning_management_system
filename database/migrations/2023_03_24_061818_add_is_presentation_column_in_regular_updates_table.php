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
        Schema::table('regular_updates', function (Blueprint $table) {
            $table->boolean('is_presentation')->default(0)->after('element_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regular_updates', function (Blueprint $table) {
            $table->dropColumn('is_presentation');
        });
    }
};
