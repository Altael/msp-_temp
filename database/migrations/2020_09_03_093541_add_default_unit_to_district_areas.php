<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultUnitToDistrictAreas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('district_areas', function (Blueprint $table) {
            $table->integer('default_unit_id')->unsigned()->nullable()->default(null);
            $table->foreign('default_unit_id')
                ->references('id')
                ->on('units')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('district_areas', function (Blueprint $table) {

        });
    }
}
