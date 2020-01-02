<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExerciseJointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_joint', function (Blueprint $table) {
            $table->bigInteger('exercise_id')->unsigned();
            $table->bigInteger('joint_id')->unsigned();
            $table->timestamps();
            $table->unique(['exercise_id', 'joint_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_joint');
    }
}
