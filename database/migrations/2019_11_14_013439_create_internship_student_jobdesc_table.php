<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipStudentJobdescTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_student_jobdesc', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('internship_student_id');
            $table->unsignedBigInteger('jobdesc_id');
            
            $table->foreign('internship_student_id')->references('id')->on('internship_students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jobdesc_id')->references('id')->on('jobdescs')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_student_jobdesc');
    }
}
