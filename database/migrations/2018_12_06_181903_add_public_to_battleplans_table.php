<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublicToBattleplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('battleplans', function (Blueprint $table) {
            $table->boolean('public')->default(false);
            $table->boolean('reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('battleplans', function($table) {
            $table->dropColumn('public');
            $table->dropColumn('reference');
        });
    }
}
