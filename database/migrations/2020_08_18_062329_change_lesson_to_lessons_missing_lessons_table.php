<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLessonToLessonsMissingLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missing_lessons', function (Blueprint $table) {
            $table->json('lesson')->change();
            $table->renameColumn('lesson', 'lessons');
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
