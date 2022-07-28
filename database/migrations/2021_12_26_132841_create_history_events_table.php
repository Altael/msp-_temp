<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_events', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');

            $table->bigInteger('action_id')->unsigned()->nullable();
            $table->foreign('action_id')->on('history_event_actions')->references('id')->onDelete('cascade');

            $table->bigInteger('item_id')->unsigned()->nullable();

            $table->json('old')->nullable();
            $table->json('new')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_events');
    }
}
