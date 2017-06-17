<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->string('latitud', 40);
            $table->string('longitud', 40);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('city_id')->references('id')->on('cities');

            $table->primary(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_locations');
    }
}
