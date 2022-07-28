<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsWhereNeeded extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        $tables = array_diff($tables, ['laravel_fulltext', 'migrations', 'password_resets', 'permission_role', 'permission_user', 'permissions']);

        foreach($tables as $table_name) {
            if(!Schema::hasColumn($table_name, 'updated_at') && !Schema::hasColumn($table_name, 'created_at')) {
                Schema::table($table_name, function (Blueprint $table) {
                    $table->timestamps();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
