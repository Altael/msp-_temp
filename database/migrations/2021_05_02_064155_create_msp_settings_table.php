<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMspSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msp_settings', function (Blueprint $table) {
            $table->id();

            $table->enum('entity', ['msp', 'unit', 'user'])->nullable();
            $table->bigInteger('entity_id')->nullable();

            $table->enum('dc_transcription_lang', ['ru', 'en', 'uk'])->default('en');
            $table->enum('dc_main_lang', ['ru', 'en', 'uk'])->default('en');

            $table->enum('standard_samgiits_type', ['random', 'list'])->default('random');
            $table->integer('standard_samgiits_amount')->default(3);
            $table->text('standard_samgiits_list')->nullable();

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
        Schema::dropIfExists('msp_settings');
    }
}
