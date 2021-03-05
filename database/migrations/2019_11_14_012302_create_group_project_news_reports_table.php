<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupProjectNewsReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_project_news_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image', 191);
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
        Schema::dropIfExists('group_project_news_reports');
    }
}
