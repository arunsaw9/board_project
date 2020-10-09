<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommitteeMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committee_meetings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->date('date');
            $table->time('time');
            $table->bigInteger('committee_id');
            $table->enum('status', [ 'over', 'scheduled' ] )->default('scheduled');
            
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
        Schema::dropIfExists('committee_meetings');
    }
}
