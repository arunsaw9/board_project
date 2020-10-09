<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlaceToBoardMeetings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('board_meetings', function (Blueprint $table) {
            $table->string('place')->nullable();
        });

        Schema::table('committee_meetings', function (Blueprint $table) {
            $table->string('place')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('board_meetings', function (Blueprint $table) {
            $table->dropColumn('place');
        });

        Schema::table('committee_meetings', function (Blueprint $table) {
            $table->dropColumn('place');
        });
    }
}
