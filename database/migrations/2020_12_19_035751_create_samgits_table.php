<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamgitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samgits', function (Blueprint $table) {
            $table->id();

            $table->text('text')->nullable();
            $table->text('translation')->nullable();
            $table->string('daymonth')->nullable();
            $table->text('mp3')->nullable();
            $table->string('title')->nullable();

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
        Schema::dropIfExists('samgiits');
    }
}
