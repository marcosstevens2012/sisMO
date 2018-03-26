<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HistorialList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
      {
        Schema::create('historial_list', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('iddetallelist');
            $table->foreign('iddetallelist')->references('id')->on('detalle_list');
            $table->string('estado');
            $table->integer('idtarea');
            $table->dateTime('fecha_hora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_list');
    }
}
