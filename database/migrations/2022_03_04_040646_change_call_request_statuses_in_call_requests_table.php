<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCallRequestStatusesInCallRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('call_requests', function (Blueprint $table) {
            $table->dropColumn('closed_status');
        });

        Schema::table('call_requests', function (Blueprint $table) {
            $table->enum('closed_status', ['successful', 'user-not-appeared','host-not-appeared', 'fail'])->default('successful');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_requests', function (Blueprint $table) {
            //
        });
    }
}
