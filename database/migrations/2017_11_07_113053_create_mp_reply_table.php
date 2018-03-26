<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMpReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_reply', function (Blueprint $table) {
            $table->increments('id');
            $table->text('reply');
            $table->integer('id_mp_comment')->unsigned();

            $table->timestamps();

            $table->foreign('id_mp_comment')->references('id')->on('mp_comments')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mp_reply');
    }
}
