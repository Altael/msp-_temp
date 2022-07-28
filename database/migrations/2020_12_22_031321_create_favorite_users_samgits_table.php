<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteUsersSamgitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_users_samgits', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('samgit_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('favorite_users_samgits', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('samgit_id')->on('samgits')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite_users_samgits');
    }
}
