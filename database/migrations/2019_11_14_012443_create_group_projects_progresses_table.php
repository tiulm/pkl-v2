<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupProjectsProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_projects_progresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('description', 191)->nullable();
            $table->string('agreement', 191)->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('group_project_id');
            
            $table->foreign('group_project_id')->references('id')->on('group_projects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_projects_progresses');
    }
}
