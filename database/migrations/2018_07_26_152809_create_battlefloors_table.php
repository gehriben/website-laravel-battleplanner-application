<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBattlefloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('battlefloors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('floor_id')
              ->nullable();
              $table->foreign('floor_id')
                ->references('id')
                ->onDelete('set null')
                ->on('floors');

            $table->unsignedInteger('battleplan_id')
              ->nullable();
            $table->foreign('battleplan_id')
                ->references('id')
                ->onDelete('cascade')
                ->on('battleplans');
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
        Schema::dropIfExists('battlefloors');
    }
}
