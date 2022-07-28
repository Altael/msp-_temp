<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUkToDailyRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_rewards', function (Blueprint $table) {
            $table->text('uk')->nullable();
            $table->string('author_uk')->nullable();
            $table->string('title_uk')->nullable();
            $table->string('source_uk')->nullable();
            $table->string('audio_author_uk')->nullable();
            $table->string('place_uk')->nullable();
            $table->string('record_date_uk')->nullable();
            $table->string('audio_ru')->nullable();
            $table->string('audio_en')->nullable();
            $table->string('audio_uk')->nullable();
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
