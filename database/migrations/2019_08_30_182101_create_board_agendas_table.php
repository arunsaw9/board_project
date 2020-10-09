<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_agendas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('uid');
            $table->text('subject');
            $table->string('category');
            $table->string('type');
            $table->enum('status', [ 'created', 'takenup', 'archive', 'defer' ] )->default('created');
            $table->bigInteger('committee_id')->default(0);
            $table->boolean('visibility')->default(false);
            $table->boolean('copied_to_committee')->default(false);

            $table->string('agenda_url')->nullable();
            $table->string('annexure_url')->nullable();
            $table->string('presentation_url')->nullable();
            $table->string('notesheet_url')->nullable();
            // $table->string('addendum_url')->nullable();
            $table->string('supplementary_url')->nullable();

            $table->date('added_at')->nullable(); // added to board meeting on | for agenda vol
            $table->time('added_at_time')->nullable(); // added to board meeting on | for agenda vol

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
        Schema::dropIfExists('board_agendas');
    }
}
