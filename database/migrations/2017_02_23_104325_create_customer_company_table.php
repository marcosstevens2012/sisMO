<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCompanyTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('customer_company', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id_customer')->unsigned();
            $table->integer('id_company')->unsigned();

            $table->primary(array('id_customer', 'id_company'));
            
            $table->timestamps();

            $table->foreign('id_customer')->references('id')->on('customers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_company')->references('id')->on('companies')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('customer_company');
    }

}
