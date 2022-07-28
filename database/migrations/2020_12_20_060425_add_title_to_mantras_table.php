<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleToMantrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mantras', function (Blueprint $table) {
            $table->string('slug')->nullable();

            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_ua')->nullable();

            $table->renameColumn('latin', 'transcription_en');
            $table->renameColumn('cyrillic', 'transcription_ru');
            $table->renameColumn('english', 'text_en');
            $table->renameColumn('russian', 'text_ru');
            $table->renameColumn('ukraine', 'text_ua');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mantras', function (Blueprint $table) {
            //
        });
    }
}
