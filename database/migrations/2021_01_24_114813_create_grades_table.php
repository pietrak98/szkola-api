<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')
                ->references('id')->on('tasks');
            $table->unsignedBigInteger('user_id');
            $table->foreign('student_id')
                ->references('id')->on('students');
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
        Schema::dropIfExists('grades');
    }
}
