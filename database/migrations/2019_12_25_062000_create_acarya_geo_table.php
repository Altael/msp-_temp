<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcaryaGeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acarya_geo', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('acarya_id')->unsigned();
            $table->foreign('acarya_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->integer('geo_id')->unsigned();

            $table->enum('type', ['sector', 'region', 'diocese', 'district', 'district_area', 'unit']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acarya_region');
    }
}
