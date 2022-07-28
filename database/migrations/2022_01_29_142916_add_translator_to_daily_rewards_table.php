<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranslatorToDailyRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_rewards', function (Blueprint $table) {
            $table->string('ru_translator_en')->nullable();
            $table->string('ru_translator_ru')->nullable();
            $table->string('ru_translator_uk')->nullable();

            $table->string('uk_translator_en')->nullable();
            $table->string('uk_translator_ru')->nullable();
            $table->string('uk_translator_uk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_reward', function (Blueprint $table) {
            //
        });
    }
}
