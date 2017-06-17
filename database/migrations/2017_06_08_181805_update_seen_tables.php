<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSeenTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('post_likes', function (Blueprint $table) {

            $table->boolean('seen')->default('0');


        });

        Schema::table('post_comments', function (Blueprint $table) {

            $table->boolean('seen')->default('0');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('post_likes', function (Blueprint $table) {

            $table->dropColumn('seen');

        });

        Schema::table('post_comments', function (Blueprint $table) {

            $table->dropColumn('seen');

        });
    }
}
