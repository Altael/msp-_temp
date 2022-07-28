<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->string('first_name')->default('');
            $table->string('middle_name')->default('');
            $table->string('last_name')->default('');
            $table->enum('sex', ['male', 'female'])->default('male');
            $table->string('profession')->default('');
            $table->string('phone')->default('');
            $table->string('acarya')->default(null)->nullable();
            $table->string('spiritual_name')->default('')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('email')->nullable();

            $table->string('image')->nullable();

            $table->integer('telegram_id')->unsigned()->nullable();

            $table->string('place_id')->nullable();
            $table->boolean('acarya_diary')->default(false);
            $table->boolean('eula')->default(false);
            $table->boolean('english')->default(false);
            $table->boolean('news')->default(false);
            $table->foreign('place_id')
                ->references('id')
                ->on('user_places')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
