<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupProjectsExaminersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_projects_examiners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role', 45);
            $table->timestamps();

            $table->unsignedBigInteger('group_project_id');
            $table->unsignedBigInteger('lecturer_id');
            
            $table->foreign('group_project_id')->references('id')->on('group_projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('lecturer_id')->references('id')->on('lecturers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_projects_examiners');
    }
}
