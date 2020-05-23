<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSquaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->increments('id');
            $table->string("color");
            $table->float("size");
            $table->timestamps();
        });

        Schema::create('line_coordinate', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->unsignedInteger('coordinate_id');
            $table->foreign('coordinate_id')
                ->references('id')
                ->on('coordinates');
            
            $table->unsignedInteger('line_id');
            $table->foreign('line_id')
                ->references('id')
                ->onDelete('cascade')
                ->on('lines');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_coordinate');
        Schema::dropIfExists('lines');
    }
}
