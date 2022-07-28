<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyPracticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_practices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamp('date');
            $table->boolean('diary')->default(false);
            $table->text('diary_text')->nullable();
            $table->boolean('guru_sakash')->default(false);
            $table->enum('pancajania', ['yes','yes_and_sleep', 'no'])->default('no');
            $table->integer('meditation_count')->unsigned()->default(0);
            $table->time('meditation_time', 0)->default(0);
            $table->integer('lalita_marmika_count')->unsigned()->default(0);
            $table->time('lalita_marmika_time', 0)->default(0);
            $table->enum('asanas', ['morning','morning_and_evening', 'evening', 'no'])->default('no');
            $table->integer('kaosiki_count')->unsigned()->default(0);
            $table->time('kaosiki_time', 0)->default(0);
            $table->integer('tandava_count')->unsigned()->default(0);
            $table->time('tandava_time', 0)->default(0);
            $table->enum('vyapaka_shaoca', ['before_any','before_all', 'before_sadhana_and_eat_or_sleep', 'no'])->default('no');
            $table->enum('full_bath', ['warm','cold', 'contrast', 'no'])->default('no');
            $table->time('svadhyaya', 0)->default(0);
            $table->time('karma_yoga', 0)->default(0);
            $table->enum('aharya', ['sattva_norm','sattva_much', 'rajah', 'tamah','no'])->default('no');
            $table->enum('dharmacakra', ['participated','had_duty', 'no'])->default('no');
            $table->enum('upavasa', ['dry','water', 'juices_fruits', 'no'])->default('no');
            $table->decimal('points', 8, 2)->default(0);
            $table->string('rank')->nullable();

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
        Schema::dropIfExists('daily_practices');
    }
}
