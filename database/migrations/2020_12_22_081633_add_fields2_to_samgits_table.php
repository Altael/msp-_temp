<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFields2ToSamgitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('samgits', function (Blueprint $table) {
            $table->integer('samgiita_number')->nullable();
            $table->string('samgiita_date')->nullable();
            $table->string('samgiita_title')->nullable();
            $table->text('samgiita_theme')->nullable();
            $table->text('samgiita_lyrics')->nullable();
            $table->text('samgiita_music')->nullable();

            $table->integer('sarkarverse_number')->nullable();
            $table->string('sarkarverse_date')->nullable();
            $table->string('sarkarverse_title')->nullable();
            $table->text('sarkarverse_theme')->nullable();
            $table->text('sarkarverse_lyrics')->nullable();
            $table->text('sarkarverse_music')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('samgits', function (Blueprint $table) {
            //
        });
    }
}
