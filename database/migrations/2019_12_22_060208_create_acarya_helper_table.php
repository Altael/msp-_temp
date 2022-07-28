<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcaryaHelperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acarya_helper', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('acarya_id')->unsigned();
            $table->foreign('acarya_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->bigInteger('helper_id')->unsigned();
            $table->foreign('helper_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acarya_helper');
    }
}
