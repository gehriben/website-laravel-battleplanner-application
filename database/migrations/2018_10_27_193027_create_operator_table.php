<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperatorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->text('colour');
            $table->boolean('attacker')->default(false);
            $table->timestamps();

            $table->unsignedInteger('media_id')->nullable();
            $table->foreign('media_id')
                ->onDelete("set null")
                ->references('id')
                ->on('medias');
        });

        Schema::create('operator_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('operator_id')->nullable();
            $table->foreign('operator_id')
                ->references('id')
                ->on('operators')
                ->onDelete("set null");

            $table->unsignedInteger('battleplan_id');
            $table->foreign('battleplan_id')
                ->references('id')
                ->on('battleplans')
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operator_slots');
        Schema::dropIfExists('operators');
    }
}
