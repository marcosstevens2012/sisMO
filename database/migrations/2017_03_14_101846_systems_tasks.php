<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SystemsTasks extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('systems_tasks', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->text('title');
            $table->text('description');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('assigned_by')->unsigned();
            $table->integer('id_state')->unsigned()->nullable();

            $table->softDeletes();
            $table->timestamps();

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
        Schema::drop('systems_tasks');
    }

}
