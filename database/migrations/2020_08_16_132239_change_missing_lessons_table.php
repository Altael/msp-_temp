<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMissingLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missing_lessons', function (Blueprint $table) {
            $table->renameColumn('acarya', 'acarya_missing');
            $table->renameColumn('receiving_date', 'initiation_date');

            $table->bigInteger('acarya_first')->unsigned()->nullable()->default(23);
            $table->foreign('acarya_first')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->boolean('acarya_changed')->default(0);

            $table->bigInteger('acarya_now')->unsigned()->nullable()->default(23);
            $table->foreign('acarya_now')
                ->references('id')
                ->on('users')
                ->onDelete('set null');


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
