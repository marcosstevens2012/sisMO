<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketTaskTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('market_task', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('id_task')->unsigned();
            $table->integer('id_market')->unsigned();

            $table->timestamps();

            $table->primary(array('id_task', 'id_market'));

            $table->foreign('id_task')->references('id')->on('tm_tasks')->onUpdate('cascade');
            $table->foreign('id_market')->references('id')->on('markets')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('market_task');
    }

}
