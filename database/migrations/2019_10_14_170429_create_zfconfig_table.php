<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZfconfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zfconfig', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('app_id');
            $table->text('private_key');
            $table->text('public_key');
            $table->text('alipay_pub_key');
            $table->string('gatewayUrl');
            $table->string('charset');
            $table->string('sign_type');
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
        Schema::dropIfExists('zfconfig');
    }
}
