<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTaskTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('customer_task', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id_task')->unsigned();
            $table->integer('id_customer')->unsigned();
            $table->integer('id_contact_type')->unsigned();
            $table->integer('id_customer_type')->unsigned();

            $table->timestamps();

            $table->primary(array('id_task', 'id_customer'));

            $table->foreign('id_task')->references('id')->on('sales_tasks')->onUpdate('cascade');
            $table->foreign('id_customer')->references('id')->on('customers')->onUpdate('cascade');
            $table->foreign('id_contact_type')->references('id')->on('contacts_types')->onUpdate('cascade');
            $table->foreign('id_customer_type')->references('id')->on('customers_types')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('customer_task');
    }

}
