<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded = [];

    /**
     * [toBind 关联绑定的机器]
     * @author Pudding 2019-09-29
     * @return [type] [description]
     */
    public function toBind()
    {
        return $this->hasOne('\App\OrderBind', 'bind_no', 'order_no');
    }
    public function configs(){
        return $this->hasOne(Zfconfig::class,'platform_code','platform');
    }
}
