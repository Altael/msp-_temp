<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSoftDeleteFromPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['acarya_geo', 'acarya_helper', 'blog_etc_post_categories', 'blog_etc_user_likes', 'role_user', 'unit_user', 'users_teachers', 'users_units_programs'];

        foreach($tables as $table_name) {
            if(Schema::hasColumn($table_name, 'deleted_at')) {
                Schema::table($table_name, function (Blueprint $table) {
                    $table->dropColumn('deleted_at');
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
        Schema::table('pivot', function (Blueprint $table) {
            //
        });
    }
}
