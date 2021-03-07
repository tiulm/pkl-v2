<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_progresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('description', 191)->nullable();
            $table->string('agreement', 191)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('internship_student_id');
            
            $table->foreign('internship_student_id')->references('id')->on('internship_students')->onDelete('cascade')->onUpdate('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_progresses');
    }
}
