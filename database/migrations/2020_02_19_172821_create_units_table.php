<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('secretary_id')->unsigned()->nullable();
            $table->foreign('secretary_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->integer('district_area_id')->unsigned()->nullable();
            $table->foreign('district_area_id')
                ->references('id')
                ->on('district_areas')
                ->onDelete('set null');
            $table->string('name')->unique();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
