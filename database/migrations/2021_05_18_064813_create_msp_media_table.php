<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMspMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msp_media', function (Blueprint $table) {
            $table->id();

            $table->string('path')->nullable()->unique();
            $table->enum('type', ['video', 'audio', 'image'])->nullable();
            $table->enum('source', ['url', 'file'])->nullable();

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
        Schema::dropIfExists('msp_media');
    }
}
