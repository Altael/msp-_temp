<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNulifyToDailyPractices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_practices', function (Blueprint $table) {
            $table->boolean('pj_nulify')->default(false);
            $table->boolean('meditation_nulify')->default(false);
            $table->boolean('kiirtan_nulify')->default(false);
            $table->boolean('asana_nulify')->default(false);
            $table->boolean('kaosiki_nulify')->default(false);
            $table->boolean('tandava_nulify')->default(false);
            $table->boolean('hb_nulify')->default(false);
            $table->boolean('fb_nulify')->default(false);
            $table->boolean('sva_nulify')->default(false);
            $table->boolean('karma_nulify')->default(false);
            $table->boolean('food_nulify')->default(false);
            $table->boolean('dc_nulify')->default(false);
            $table->boolean('fast_nulify')->default(false);
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
