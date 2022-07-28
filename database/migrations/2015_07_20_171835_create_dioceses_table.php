<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiocesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dioceses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->unsigned()->nullable();
            $table->text('notes')->nullable();

            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('set null');
            $table->string('name')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dioecesis');
    }
}
