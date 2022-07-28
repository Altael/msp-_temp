<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToUnitsPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units_programs', function (Blueprint $table) {
            $table->integer('initiated_guests')->default(0);
            $table->integer('not_initiated_guests')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units_programs', function (Blueprint $table) {
            //
        });
    }
}
