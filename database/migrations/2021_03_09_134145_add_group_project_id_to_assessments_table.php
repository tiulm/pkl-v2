<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupProjectIdToAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessments', function (Blueprint $table) {
            
            $table->unsignedBigInteger('group_project_id')->nullable();
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
        Schema::table('assessments', function (Blueprint $table) {
            //
        });
    }
}
