<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterZfconfigAddPlatfprmCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zfconfig', function (Blueprint $table) {
            $table->string('platform_code'); //平台名称
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zfconfig', function (Blueprint $table) {
            $table->string('platform_code'); //平台名称
        });
    }
}
