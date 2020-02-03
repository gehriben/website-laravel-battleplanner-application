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
            $table->text('icon');
            $table->text('colour');
            $table->boolean('atk');
            $table->timestamps();
        });

        Schema::create('operator_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('operator_id')->nullable();
            $table->unsignedInteger('battleplan_id');
            $table->timestamps();

            $table->foreign('operator_id')
                ->references('id')
                ->on('operators')
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->foreign('battleplan_id')
                ->references('id')
                ->on('battleplans')
                ->onDelete("cascade")
                ->onUpdate("cascade");
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
