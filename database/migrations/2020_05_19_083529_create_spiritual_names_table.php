<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpiritualNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spiritual_names', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('sanskrit')->default('');
            $table->string('en')->nullable();
            $table->string('ru')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_ru')->nullable();
            $table->enum('sex', ['male', 'female'])->default('male');
            $table->boolean('status')->default(false);

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
        Schema::dropIfExists('spiritual_names');
    }
}
