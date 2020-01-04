<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJointRomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('joint_rom', function (Blueprint $table) {
            $table->bigInteger('joint_id')->unsigned();
            $table->bigInteger('rom_id')->unsigned();
            $table->unique(['joint_id', 'rom_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('joint_rom');
    }
}
