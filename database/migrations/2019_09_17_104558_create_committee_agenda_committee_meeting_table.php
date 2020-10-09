<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitteeAgendaCommitteeMeetingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committee_agenda_committee_meeting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('committee_agenda_id');
            $table->bigInteger('committee_meeting_id');
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
        Schema::dropIfExists('committee_agenda_committee_meeting');
    }
}
