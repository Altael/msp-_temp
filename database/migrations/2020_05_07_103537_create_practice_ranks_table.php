<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticeRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_ranks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->decimal('points', 8, 2)->default(0);
            $table->decimal('percent', 8, 2)->default(0);
            $table->string('guna');

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
        Schema::dropIfExists('practice_ranks');
    }
}
