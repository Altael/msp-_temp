<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUnitUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_user', function (Blueprint $table) {
            $table->bigInteger('title_id')->unsigned()->nullable();
        });
        Schema::table('unit_user', function (Blueprint $table) {
            $table->foreign('title_id')->on('unit_titles')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
