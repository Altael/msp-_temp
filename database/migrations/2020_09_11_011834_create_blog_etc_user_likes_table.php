<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogEtcUserLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_etc_user_likes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->integer('post_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('blog_etc_user_likes', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('post_id')->on('blog_etc_posts')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_etc_user_likes');
    }
}
