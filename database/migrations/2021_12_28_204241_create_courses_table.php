<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('slug')->nullable();
            $table->json('author_ids')->nullable();
            $table->json('name')->nullable();
            $table->json('description')->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('published')->default(false);
            $table->string('default_language')->default('en');
            $table->integer('schedule')->default(0);
            $table->enum('mode', ['scheduled', 'user_checked', 'curator_checked'])->default('user_checked');
            $table->integer('order')->default(0);
            $table->boolean('exam')->default(false);

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
        Schema::dropIfExists('courses');
    }
}
