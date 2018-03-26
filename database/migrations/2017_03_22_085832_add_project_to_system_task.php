<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProjectToSystemTask extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('systems_tasks', function (Blueprint $table) {
            $table->integer('id_project')->unsigned();
            
             $table->foreign('id_project')->references('id')->on('projects')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('systems_tasks', function($table) {
             $table->dropForeign(['id_project']);
            $table->dropColumn('id_project');
        });
    }

}
