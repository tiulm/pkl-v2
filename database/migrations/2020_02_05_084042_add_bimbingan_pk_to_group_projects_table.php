<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBimbinganPkToGroupProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_projects', function (Blueprint $table) {
            $table->string('bimbingan_pk', 255)->nullable();
            $table->string('kak', 255)->nullable();
            $table->string('persetujuan', 255)->nullable();
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
