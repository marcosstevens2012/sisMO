<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTmTasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tm_tasks', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->text('product');
            $table->integer('id_calendar')->unsigned();
            $table->integer('assigned_by')->unsigned();
            $table->integer('id_state')->unsigned()->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_calendar')->references('id')->on('calendar')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('assigned_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('states')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
         Schema::drop('tm_tasks');
    }

}
