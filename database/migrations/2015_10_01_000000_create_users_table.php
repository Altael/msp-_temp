<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();

            $table->integer('district_area_id')->unsigned()->nullable();
            $table->foreign('district_area_id')
                ->references('id')
                ->on('district_areas')
                ->onDelete('set null');

            $table->enum('language', ['ru','en'])->default('en');

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->boolean('registration_completed')->default(false);
            $table->boolean('hidden')->default(false);
            $table->text('notes')->nullable();
            $table->boolean('notify_name')->default(false);
            $table->timestamps();
        });

        Schema::table('districts', function($table) {
            $table->foreign('bp_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
