<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->boolean('competitive');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('thumbnail_id')->nullable();
            $table->foreign('thumbnail_id')
                ->onDelete("set null")
                ->references('id')
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
        Schema::dropIfExists('maps');
    }
}
