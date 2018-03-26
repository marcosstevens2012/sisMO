<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSubareaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('customer_subarea', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id_customer')->unsigned();
            $table->integer('id_subarea')->unsigned();

            $table->timestamps();

            $table->primary(['id_customer', 'id_subarea']);

            $table->foreign('id_customer')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_subarea')->references('id')->on('subareas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('customer_subarea');
    }

}
