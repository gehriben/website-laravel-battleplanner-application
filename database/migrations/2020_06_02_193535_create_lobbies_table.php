<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLobbiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lobbies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('connection_string');
            $table->timestamps();

            $table->unsignedInteger('owner_id')->nullable();
            $table->foreign('owner_id')
                ->onDelete("cascade")
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lobbies');
    }
}
