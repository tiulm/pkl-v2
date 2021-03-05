<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternshipStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internship_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nim', 13)->unique();
            $table->string('status', 191)->nullable();
            $table->string('name', 191);
            $table->string('gender', 191)->nullable();
            $table->char('angkatan', 4)->nullable();
            $table->double('ip_sem', 4, 2)->nullable();
            $table->integer('sks_sem')->nullable();
            $table->double('ipk', 4, 2)->nullable();
            $table->integer('sks_total')->nullable();
            $table->string('phone_number', 191)->nullable();
            $table->string('image_profile', 191)->nullable();
            $table->timestamps();
            
            $table->unsignedBigInteger('user_id');
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internship_students');
    }
}
