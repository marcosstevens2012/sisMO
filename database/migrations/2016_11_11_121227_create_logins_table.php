<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('logins', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id_user')->unsigned();
            $table->datetime('start_date')->unique();
            $table->datetime('end_date')->unique()->nullable();

            $table->primary(array('id_user','start_date'));

            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('logins');
    }

}
