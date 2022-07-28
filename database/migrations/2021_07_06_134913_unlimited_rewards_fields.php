<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UnlimitedRewardsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_rewards', function (Blueprint $table) {
            $table->string('en_comentary_seju_en')->nullable();
            $table->string('en_comentary_seju_ru')->nullable();
            $table->string('en_comentary_seju_uk')->nullable();
            $table->string('ru_comentary_seju_en')->nullable();
            $table->string('ru_comentary_seju_ru')->nullable();
            $table->string('ru_comentary_seju_uk')->nullable();
            $table->string('uk_comentary_seju_en')->nullable();
            $table->string('uk_comentary_seju_ru')->nullable();
            $table->string('uk_comentary_seju_uk')->nullable();

            $table->enum('original_comentary_lang', ['en', 'ru', 'uk'])->default('en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
