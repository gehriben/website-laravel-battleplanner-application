<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('map_id');
            $table->foreign('map_id')
                ->references('id')
                ->onDelete("cascade")
                ->on('maps');

            $table->unsignedInteger('source_id')->nullable();
            $table->foreign('source_id')
                ->references('id')
                ->onDelete("set null")
                ->on('medias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('floors');
    }
}
