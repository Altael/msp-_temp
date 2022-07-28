<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyRewardsMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_rewards_media', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('reward_id')->unsigned();
            $table->bigInteger('media_id')->unsigned();
            $table->enum('lang', ['en', 'ru', 'uk', 'all'])->default('all');

            $table->timestamps();
        });

        Schema::table('daily_rewards_media', function (Blueprint $table) {
            $table->foreign('reward_id')->on('daily_rewards')->references('id')->onDelete('cascade');
            $table->foreign('media_id')->on('msp_media')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_rewards_media');
    }
}
