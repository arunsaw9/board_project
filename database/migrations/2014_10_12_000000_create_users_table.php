<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('designation')->nullable();
            $table->enum('role', [ 'admin', 'user', 'invitee' ] )->default('user');
            $table->boolean('mailnotifications')->default(true);
            $table->boolean('smsnotifications')->default(true);
            $table->string('password');
            $table->rememberToken();

            $table->timestamp('last_login_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
