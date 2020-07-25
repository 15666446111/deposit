<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountToZfconfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zfconfig', function (Blueprint $table) {
            $table->string('account')->nullable()->comment('支付宝收款账号')->after('app_id');
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
            //
        });
    }
}
