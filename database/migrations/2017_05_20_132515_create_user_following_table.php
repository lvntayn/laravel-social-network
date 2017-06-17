<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFollowingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_following', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('following_user_id')->unsigned();
            $table->integer('follower_user_id')->unsigned();
            $table->boolean('allow')->default(0);

            $table->foreign('following_user_id')
                ->references('id')->on('users')->onDelete("CASCADE");

            $table->foreign('follower_user_id')
                ->references('id')->on('users')->onDelete("CASCADE");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_following');
    }
}
