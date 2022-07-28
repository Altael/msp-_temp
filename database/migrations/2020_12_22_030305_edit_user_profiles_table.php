<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {

            $table->dropColumn('dc_transcription_lang');
            $table->dropColumn('dc_main_lang');

        });

        Schema::table('user_profiles', function (Blueprint $table) {

            $table->enum('dc_transcription_lang', ['ru', 'en', 'uk'])->default('ru');
            $table->enum('dc_main_lang', ['ru', 'en', 'uk'])->default('ru');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
