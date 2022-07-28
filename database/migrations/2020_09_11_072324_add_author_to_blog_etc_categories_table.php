<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorToBlogEtcCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_etc_categories', function (Blueprint $table) {

            $table->string('author_avatar')->nullable();
            $table->string('author_name_en')->nullable();
            $table->string('author_name_ru')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_etc_categories', function (Blueprint $table) {
            //
        });
    }
}
