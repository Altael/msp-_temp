<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToDailyRewards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_rewards', function (Blueprint $table) {
            $table->enum('type', ['daily', 'quote', 'story'])->nullable();
            $table->string('date_place')->nullable();
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
