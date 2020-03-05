<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table->bigIncrements('id');
        $table->string('name');
        $table->string('path');
        $table->timestamps();

        // Foreign keys
        // Owner
        $table->unsignedBigInteger('user_id')->nullable();
        $table->foreign('user_id')
            ->references('id')
            ->onDelete('cascade')
            ->on('users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maps');
    }
}
