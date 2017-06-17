<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->boolean("private")->default(0);
            $table->date("birthday")->nullable();
            $table->boolean('sex')->default(0);
            $table->string('phone', 20)->nullable();
            $table->string('bio', 140)->nullable();
            $table->string('profile_path', 191)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('private');
            $table->dropColumn('birthday');
            $table->dropColumn('sex');
            $table->dropColumn('phone');
            $table->dropColumn('bio');
            $table->dropColumn('profile_path');

        });
    }
}
