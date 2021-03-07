<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('agency', 191)->nullable();
            $table->string('description', 191)->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('lecturer_id');
            $table->unsignedBigInteger('internship_student_id')->nullable();
            
            $table->foreign('lecturer_id')->references('id')->on('lecturers')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('recommendations');
    }
}
