<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePracticePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_points', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->unique();
            $table->decimal('points', 8, 2)->default(0);
            $table->decimal('fee')->default(0);
            $table->decimal('time', 8, 2)->default(0);

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
        Schema::dropIfExists('practice_points');
    }
}
