<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamgitsMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samgits_media', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('samgit_id')->unsigned();
            $table->bigInteger('media_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('samgits_media', function (Blueprint $table) {
            $table->foreign('samgit_id')->on('samgits')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('samgits_media');
    }
}
