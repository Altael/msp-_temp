<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemakeDailyRewards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_rewards', function (Blueprint $table) {
            $table->dropColumn('date_place');
            $table->date('record_date')->nullable();
            $table->string('place_en')->nullable();
            $table->string('place_ru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_rewards', function (Blueprint $table) {
            //
        });
    }
}
