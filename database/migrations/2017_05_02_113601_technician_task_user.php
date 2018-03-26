<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TechnicianTaskUser extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('technician_task_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id_task')->unsigned();
            $table->integer('id_user')->unsigned();

            $table->timestamps();

            $table->primary(array('id_task', 'id_user'));

            $table->foreign('id_task')->references('id')->on('technician_tasks')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('technician_task_user');
    }

}
