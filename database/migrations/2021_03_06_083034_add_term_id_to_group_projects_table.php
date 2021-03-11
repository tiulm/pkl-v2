<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermIdToGroupProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_projects', function (Blueprint $table) {
            $table->unsignedBigInteger('term_id')->nullable();
            
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_projects', function (Blueprint $table) {
            //
        });
    }
}
