<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comment');
            $table->integer('id_user')->unsigned();
            $table->integer('id_mp_task')->unsigned();

            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('id_mp_task')->references('id')->on('mp_tasks')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mp_comments');
    }
}
