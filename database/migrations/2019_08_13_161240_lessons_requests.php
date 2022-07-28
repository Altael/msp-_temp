<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LessonsRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons_requests', static function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->tinyInteger('lesson')->unsigned();
            $table->enum('type', ['check', 'get']);
            $table->smallInteger('status')
                ->index()
                ->default(0)
                ->unsigned();
            $table->integer('meditation_hours')->default(0);
            $table->timestamp('creation_date')->useCurrent();

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
        Schema::dropIfExists('lessons_requests');
    }
}
