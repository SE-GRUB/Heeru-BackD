<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('no_telp')->unique();
            $table->string('email')->nullable();
            $table->text('profile_pic')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->foreign('program_id')->references('id')->on('programs');
            $table->string('nip')->unique()->nullable();
            $table->unsignedBigInteger('fare')->nullable();
            $table->text('description')->nullable();
            $table->integer('rating')->nullable();
            $table->string('role');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};