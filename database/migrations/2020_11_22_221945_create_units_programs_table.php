<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units_programs', function (Blueprint $table) {
            $table->id();

            $table->timestamp('date')->nullable();

            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('program_id')->unsigned();
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('units_programs');
    }
}
