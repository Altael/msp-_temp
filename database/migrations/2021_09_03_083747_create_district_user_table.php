<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('district_user', function (Blueprint $table) {
            $table->id();

            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->on('districts')->references('id')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');

            $table->enum('rank', ['BP', 'ABP', 'TBP'])->default('BP');

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
        Schema::dropIfExists('district_user');
    }
}
