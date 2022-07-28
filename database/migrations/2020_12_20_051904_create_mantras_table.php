<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantras', function (Blueprint $table) {
            $table->id();

            $table->text('latin')->nullable();
            $table->text('cyrillic')->nullable();
            $table->text('english')->nullable();
            $table->text('russian')->nullable();
            $table->text('ukraine')->nullable();
            $table->text('mp3')->nullable();

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
        Schema::dropIfExists('mantras');
    }
}
