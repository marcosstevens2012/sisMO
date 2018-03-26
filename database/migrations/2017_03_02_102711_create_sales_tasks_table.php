<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sales_tasks', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->text('title');
            $table->text('description');
            $table->dateTime('date');
            $table->text('response')->nullable();
            $table->text('observation')->nullable();
            $table->integer('assigned_by')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('assigned_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('sales_tasks');
    }

}
