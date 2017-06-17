<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDirectMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_direct_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_user_id')->unsigned();
            $table->integer('receiver_user_id')->unsigned();
            $table->text('message');
            $table->boolean('seen')->default(0);
            $table->boolean('sender_delete')->default(0);
            $table->boolean('receiver_delete')->default(0);


            $table->foreign('sender_user_id')
                ->references('id')->on('users');

            $table->foreign('receiver_user_id')
                ->references('id')->on('users');

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
        Schema::dropIfExists('user_direct_messages');
    }
}
