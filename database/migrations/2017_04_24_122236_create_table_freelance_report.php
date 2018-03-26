<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFreelanceReport extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('freelance_report', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger('dni');
            $table->float('price');
            $table->integer('id_freelance')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_freelance')->references('id')->on('freelance')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('freelance_report');
    }

}
