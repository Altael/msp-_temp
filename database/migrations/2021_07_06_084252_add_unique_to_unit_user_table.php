<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueToUnitUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('unit_user')->get();

        do{
            $duplicates = DB::table('unit_user')
                ->select('id')
                ->whereIn('id', function ($q){
                    $q->select('id')
                        ->from('unit_user')
                        ->groupBy('unit_id', 'user_id')
                        ->havingRaw('COUNT(*) > 1');
                })->get();

            foreach($duplicates as $duplicate) {
                DB::table('unit_user')->where('id', $duplicate->id)->delete();
            }
        } while(count($duplicates));

        Schema::table('unit_user', function (Blueprint $table) {
            $table->unique(['user_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_user', function (Blueprint $table) {
            //
        });
    }
}
