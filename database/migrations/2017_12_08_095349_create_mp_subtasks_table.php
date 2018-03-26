<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpSubtasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mp_subtasks', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('id_mp_task')->unsigned();
            $table->integer('assigned_by')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_mp_task')->references('id')->on('mp_tasks')->onUpdate('cascade');
            $table->foreign('assigned_by')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mp_subtasks');
    }

}
