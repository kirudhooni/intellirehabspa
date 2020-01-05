<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJointTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joint_target', function (Blueprint $table) {
            $table->bigInteger('joint_id')->unsigned();
            $table->bigInteger('target_id')->unsigned();
            $table->bigInteger('rom_id')->unsigned();
            $table->bigInteger('rom_value')->unsigned();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joint_target');
    }
}
