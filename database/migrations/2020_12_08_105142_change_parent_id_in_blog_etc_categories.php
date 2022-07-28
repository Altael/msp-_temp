<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeParentIdInBlogEtcCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_etc_categories', function (Blueprint $table) {
            $table->dropForeign('blog_etc_categories_parent_id_foreign');
            $table->foreign('parent_id')
                ->references('id')
                ->on('blog_etc_categories')
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
        Schema::table('blog_etc_categories', function (Blueprint $table) {
            //
        });
    }
}
