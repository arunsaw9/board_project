<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriorityToBoardAgendas extends Migration
{
    public function up()
    {
        Schema::table('board_agendas', function (Blueprint $table) {
            $table->integer('priority')->default(99);
        });
    }

    public function down()
    {
        Schema::table('board_agendas', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
}
