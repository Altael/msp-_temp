<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MeditationLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meditation_lessons', static function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('from_user_id')->unsigned();
            $table->foreign('from_user_id')
                ->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('lesson_number')->unsigned();
            $table->timestamp('receiving_date')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meditation_lessons');
    }
}
