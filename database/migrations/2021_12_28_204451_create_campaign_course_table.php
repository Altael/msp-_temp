<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_course', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('campaign_id')->unsigned()->nullable();
            $table->foreign('campaign_id')->on('campaigns')->references('id')->onDelete('cascade');

            $table->bigInteger('course_id')->unsigned()->nullable();
            $table->foreign('course_id')->on('courses')->references('id')->onDelete('cascade');

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
        Schema::dropIfExists('campaign_course');
    }
}
