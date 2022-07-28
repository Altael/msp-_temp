<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPracticesToDailyPractices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_practices', function (Blueprint $table) {
            $table->boolean('oaths')->default(false);
            $table->boolean('guru_mantra')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_practices', function (Blueprint $table) {
            //
        });
    }
}
