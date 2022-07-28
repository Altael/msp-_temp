<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_areas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('district_id')->unsigned()->nullable();
            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('set null');

            $table->string('name')->unique();
            $table->text('notes')->nullable();
            $table->string('place_id')->unique();
            $table->enum('type', ['city', 'region', 'country']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('district_areas');
    }
}
