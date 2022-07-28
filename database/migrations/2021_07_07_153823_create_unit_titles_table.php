<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_titles', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable();

            $table->string('name_en')->nullable();
            $table->string('name_ru')->nullable();
            $table->string('name_uk')->nullable();

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
        Schema::dropIfExists('unit_titles');
    }
}
