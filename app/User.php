<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    const GROUPS_MARKET="sales";
    const GROUPS_SERVICE="service";

    public $groupsNameMaps = [
        self::GROUPS_MARKET=>"销售",
        self::GROUPS_SERVICE=>"客服",
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password','platform','platform_code','platform_role','groups','isLeader'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * [orderMany 关联业务员的订单]
     * @author Pudding 2019-09-26
     * @return [type] [description]
     */
    public function orderMany()
    {
         return $this->hasMany('\App\Order',  'order_parent', 'username')->whereNotNull('alipay_payer_user');
    }

    
    public function configs(){
        return $this->hasOne(Zfconfig::class,'platform','platform');
    }
}
