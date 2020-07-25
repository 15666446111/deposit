<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZfbusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zfbusers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->unique();
            $table->string('nickname')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('avatar')->nullable();
            $table->string('gender')->nullable();
            $table->string('user_type')->nullable();
            $table->string('user_status')->nullable();
            $table->string('is_certified')->nullable();
            $table->string('is_student_certified')->nullable();
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
        Schema::dropIfExists('zfbusers');
    }
}
