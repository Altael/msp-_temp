<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustTablesForDeletingUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->unique(['email', 'deleted_at']);
        });

        Schema::table('user_socials', function (Blueprint $table) {
            $table->dropUnique(['social_id', 'provider']);
            $table->unique(['social_id', 'provider', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unique(['email']);
            $table->dropUnique(['email', 'deleted_at']);
        });

        Schema::table('user_socials', function (Blueprint $table) {
            $table->unique(['social_id', 'provider']);
            $table->dropUnique(['social_id', 'provider', 'deleted_at']);
        });
    }
}
