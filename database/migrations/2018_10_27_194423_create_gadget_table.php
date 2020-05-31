<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGadgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gadgets', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedInteger('icon_id')->nullable();
            $table->foreign('icon_id')
                ->references('id')
                ->onDelete('set null')
                ->on('medias');
        });

        Schema::create('operator_gadget', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->unsignedInteger('operator_id');
            $table->foreign('operator_id')
                ->references('id')
                ->on('operators')
                ->onDelete("cascade");

            $table->unsignedInteger('gadget_id');
            $table->foreign('gadget_id')
                ->references('id')
                ->on('gadgets')
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
        Schema::dropIfExists('gadgets');
    }
}
