<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionTask extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('action_task', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id_task')->unsigned();
            $table->integer('id_action')->unsigned();
            $table->dateTime('start_date');
            $table->dateTime('end_date');

            $table->timestamps();

            $table->primary(array('id_task', 'id_action'));

            $table->foreign('id_task')->references('id')->on('tm_tasks')->onUpdate('cascade');
            $table->foreign('id_action')->references('id')->on('tm_actions')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('action_task');
    }

}
