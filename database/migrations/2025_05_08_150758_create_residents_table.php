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
        Schema::create('residents', function (Blueprint $table) {
            $table->id('id');
            $table->string('name');
            $table->string('ktp_photo');
            $table->enum('status', ['kontrak', 'tetap'])->default('kontrak');
            $table->string('phone_number');
            $table->boolean('is_married');
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
        Schema::drop('residents');
    }
};
