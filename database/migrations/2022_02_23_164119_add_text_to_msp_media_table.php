<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextToMspMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('msp_media', function (Blueprint $table) {

            $table->text('text')->nullable();

        });
        Schema::table('msp_media', function (Blueprint $table) {

            DB::statement('ALTER TABLE msp_media ADD FULLTEXT msp_media_text_fulltext(text)');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('msp_media', function (Blueprint $table) {
            //
        });
    }
}
