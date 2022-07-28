<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Questions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', static function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('from_user_id')->unsigned();
            $table->foreign('from_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->bigInteger('to_user_id')->unsigned();
            $table->foreign('to_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->string('subject');
            $table->smallInteger('status')
                ->unsigned()
                ->default(0)
                ->comment('0 - new, 1 - in progress, 2 - completed');
            $table->timestamp('last_message_date')->useCurrent();
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
        Schema::dropIfExists('questions');
    }
}
