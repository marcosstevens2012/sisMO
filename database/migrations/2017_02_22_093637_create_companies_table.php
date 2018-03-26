<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('companies', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('company')->unique();
            $table->string('address');
            $table->string('email')->unique();
            $table->bigInteger('phone')->unsigned();
            $table->integer('id_category')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('id_category')->references('id')->on('company_category')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('companies');
    }

}
