<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_requests', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamp('date')->nullable();
            $table->string('user_phone')->nullable();
            $table->enum('user_messenger', ['telegram', 'viber', 'whatsApp'])->default('telegram');

            $table->bigInteger('call_id')->unsigned()->nullable();
            $table->foreign('call_id')->on('calls')->references('id')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('host_id')->unsigned()->nullable();
            $table->foreign('host_id')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');

            $table->json('guest_ids')->nullable();
            $table->text('description')->nullable();
            $table->boolean('closed')->default(false);
            $table->enum('closed_status', ['successful', 'postponed', 'user-not-appeared', 'host-not-appeared'])->default('successful');
            $table->timestamp('closed_date')->nullable();
            $table->bigInteger('closed_id')->unsigned()->nullable();
            $table->text('closed_notes')->nullable();

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
        Schema::dropIfExists('call_requests');
    }
}
