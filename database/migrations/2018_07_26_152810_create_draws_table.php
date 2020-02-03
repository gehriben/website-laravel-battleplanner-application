<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->increments('id');
            $table->float("originX", 10, 5);
            $table->float("originY", 10, 5);
            $table->float("destinationX", 10, 5);
            $table->float("destinationY", 10, 5);
            $table->morphs('drawable');
            $table->boolean("saved")->default(false);
            $table->unsignedInteger('battlefloor_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('user_id')
              ->references('id')
              ->on('users');

            $table->foreign('battlefloor_id')
              ->references('id')
              ->onDelete('cascade')
              ->on('battlefloors');

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
        Schema::dropIfExists('draws');
    }
}
