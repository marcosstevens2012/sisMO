<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpSubcommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_subcomments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('subcomment');
            $table->integer('id_user')->unsigned();
            $table->integer('id_mp_subtask')->unsigned();

            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('id_mp_subtask')->references('id')->on('mp_subtasks')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mp_subcomments');
    }
}
