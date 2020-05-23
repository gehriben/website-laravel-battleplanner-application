<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattleplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battleplans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longtext('description');
            $table->longtext('notes');
            $table->boolean('public')->default(false);
            $table->timestamps();

            $table->unsignedInteger('owner_id')->nullable();
            $table->foreign('owner_id')
              ->references('id')
              ->on('users');

            $table->unsignedInteger('map_id')->nullable();
            $table->foreign('map_id')
              ->references('id')
              ->onDelete('set null')
              ->on('maps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('battleplans');
    }
}
