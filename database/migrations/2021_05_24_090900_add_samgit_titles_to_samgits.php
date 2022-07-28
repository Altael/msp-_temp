<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSamgitTitlesToSamgits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('samgits', function (Blueprint $table) {
            $table->renameColumn('samgiita_title', 'title_en');
            $table->string('title_ru')->nullable();
            $table->string('title_uk')->nullable();
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
