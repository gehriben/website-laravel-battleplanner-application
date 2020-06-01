<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('squares', function (Blueprint $table) {
            $table->increments('id');
            $table->float("opacity", 10, 5);
            $table->string("color");
            $table->timestamps();

            $table->unsignedInteger('origin_id');
            $table->foreign('origin_id')
                ->references('id')
                ->on('coordinates');

            $table->unsignedInteger('destination_id');
            $table->foreign('destination_id')
                ->references('id')
                ->on('coordinates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('squares');
    }
}
