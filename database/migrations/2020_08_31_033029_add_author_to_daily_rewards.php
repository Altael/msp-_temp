<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorToDailyRewards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_rewards', function (Blueprint $table) {
            $table->text('author_ru')->nullable();
            $table->text('author_en')->nullable();
            $table->text('ru')->nullable()->change();
            $table->text('en')->nullable()->change();
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
