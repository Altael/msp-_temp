<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stages', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable();

            $table->bigInteger('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->on('courses')->references('id')->onDelete('cascade');

            $table->integer('order')->default(0);
            $table->json('name')->nullable();
            $table->json('description')->nullable();
            $table->json('videos')->nullable();
            $table->text('content')->nullable();
            $table->string('default_language')->default('en');
            $table->boolean('published')->default(false);
            $table->enum('finish_type', ['user_checked', 'curator_checked'])->default('user_checked');

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
        Schema::dropIfExists('stages');
    }
}
