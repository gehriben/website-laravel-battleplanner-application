<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('battleplan_id')
              ->nullable();
              $table->foreign('battleplan_id')
                ->references('id')
                ->onDelete('set null')
                ->on('battleplans');

            $table->unsignedInteger('owner')
              ->nullable();
              $table->foreign('owner')
                ->references('id')
                ->on('users');

            $table->string('connection_string');
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
        Schema::dropIfExists('rooms');
    }
}
