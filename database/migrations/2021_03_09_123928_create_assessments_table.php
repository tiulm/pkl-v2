<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('group_assessment')->nullable();
            $table->integer('intern_assessment')->nullable();
            $table->integer('final_assessment')->nullable();
            $table->string('grade', 191)->nullable();
            
            $table->unsignedBigInteger('internship_student_id')->nullable();
            $table->foreign('internship_student_id')->references('id')->on('internship_students')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}
