<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFieldsInSamgitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('samgits', function (Blueprint $table) {
            $table->renameColumn('text', 'transcription_en');
            $table->renameColumn('translation', 'translation_en');
            $table->renameColumn('cyrillic', 'transcription_ru');
            $table->renameColumn('russian', 'translation_ru');
            $table->renameColumn('ukraine', 'translation_uk');
            $table->text('transcription_uk')->nullable();
        });

        Schema::table('mantras', function (Blueprint $table) {
            $table->text('transcription_uk')->nullable();
            $table->renameColumn('text_ua', 'text_uk');
            $table->renameColumn('title_ua', 'title_uk');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('samgits', function (Blueprint $table) {
            //
        });
    }
}
