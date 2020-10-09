<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardAgendaBoardMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_agenda_board_meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('board_agenda_id');
            $table->bigInteger('board_meeting_id');
            $table->enum('status', [ 'archive', 'defer', 'takenup' ] )->default('takenup');
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
        Schema::dropIfExists('board_agenda_board_meeting');
    }
}
