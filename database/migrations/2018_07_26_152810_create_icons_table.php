<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icons', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('source_id')->nullable();
            $table->foreign('source_id')
                ->references('id')
                ->onDelete('set null')
                ->on('medias');

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
        Schema::dropIfExists('icons');
    }
}
