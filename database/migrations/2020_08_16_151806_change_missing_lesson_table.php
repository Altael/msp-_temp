<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMissingLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missing_lessons', function (Blueprint $table) {
            $table->text('acarya_missing')->nullable()->change();
            $table->text('acarya_first_missing')->nullable();
            $table->bigInteger('acarya_first')->unsigned()->nullable()->default(null)->change();
            $table->bigInteger('acarya_now')->unsigned()->nullable()->default(null)->change();
            $table->date('initiation_date')->nullable()->change();
        });

        Schema::table('meditation_lessons', function (Blueprint $table) {
            $table->bigInteger('from_user_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missing_lessons', function (Blueprint $table) {
            //
        });
    }
}
