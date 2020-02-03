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
            $table->text('description')->nullable();
            $table->boolean("saved")->default(false);

            $table->unsignedInteger('owner_id')
              ->nullable();
              $table->foreign('owner_id')
                ->references('id')
                ->on('users');

            $table->unsignedInteger('gametype_id')
              ->nullable();
              $table->foreign('gametype_id')
                ->references('id')
                ->onDelete('set null')
                ->on('gametypes');

            $table->unsignedInteger('map_id')
              ->nullable();
              $table->foreign('map_id')
                ->references('id')
                ->onDelete('set null')
                ->on('maps');

            $table->text('notes')->nullable();
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
        Schema::dropIfExists('battleplans');
    }
}
