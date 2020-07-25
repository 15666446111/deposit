<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zfconfig extends Model
{

    protected $table = 'zfconfig';
    protected $fillable = ['username','app_id','private_key','public_key','alipay_pub_key','gatewayUrl','charset','sign_type','platform','platform_code','account'];
}
