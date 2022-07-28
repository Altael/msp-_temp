<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSamgitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('samgits', function (Blueprint $table) {
            $table->text('cyrillic')->nullable();
            $table->text('russian')->nullable();
            $table->text('ukraine')->nullable();
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
