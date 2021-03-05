<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('NIP', 18)->unique()->nullable();
            $table->string('NIDN', 10)->unique()->nullable();
            $table->string('name', 255);
            $table->string('last_education', 255)->nullable();
            $table->integer('status')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('phone_number', 45)->nullable();
            $table->string('email', 191)->unique()->nullable();
            $table->string('image_profile', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecturers');
    }
}
