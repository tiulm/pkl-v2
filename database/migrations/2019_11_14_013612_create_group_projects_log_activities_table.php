<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupProjectsLogActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_projects_log_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->text('description');
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
        Schema::dropIfExists('group_projects_log_activities');
    }
}
