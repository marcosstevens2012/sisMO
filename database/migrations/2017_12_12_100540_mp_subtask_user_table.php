<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MpSubtaskUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mp_subtask_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id_mp_subtask')->unsigned();
            $table->integer('id_user')->unsigned();

            $table->timestamps();

            $table->primary(array('id_mp_subtask', 'id_user'));

            $table->foreign('id_mp_subtask')->references('id')->on('mp_subtasks')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mp_subtask_user');
    }
}
