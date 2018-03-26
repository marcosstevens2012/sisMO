<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpActionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_task_action', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_mp_task')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->string('action');

            $table->timestamps();

            $table->foreign('id_mp_task')->references('id')->on('mp_tasks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mp_task_action');
    }
}
