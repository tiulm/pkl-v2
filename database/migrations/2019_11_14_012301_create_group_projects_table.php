<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('is_verified');
            $table->string('title', 191);
            $table->string('progress', 45)->nullable();
            $table->string('field_supervisor', 45)->nullable();
            $table->date('start_intern')->nullable();
            $table->date('end_intern')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('agency_id');
            
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_projects');
    }
}
