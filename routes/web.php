<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * 后台登录类路由 不需要验证
 */
Route::get('/login', 'LoginController@index')->name('login');

Route::post('/loginCheck', 'LoginController@checkValation')->name('login.ck');
Route::any('/payments','AliController@payments');       // 更改支付宝订单姓名
/**
 * 后台操作相关路由 需要登录之后 验证中间件才可以使用
 */

Route::group(['middleware' => ['UserLogin']], function () {

    Route::get('/',         'HomeController@index');

    Route::get('/qrcode',   'UserController@qrcode');

    Route::get('/Aliorder/{order_parent?}', 'UserController@Aliorder');
    Route::match(['get', 'post'],'/AliAuthconfig/{username?}',  'AliController@Aliconfig')->name('AliAuthconfig');       // 支付宝授权信息配置

    Route::any('/resetPass','UserController@resetPass');

    Route::get('/logot',    'UserController@loginOut');

    Route::any('/AccountList', 'UserController@AccountList')->name('AccountList');  // 帐号列表
    Route::any('/ban/{account}', 'UserController@ban_account')->name('ban_account');  // 帐号列表


    Route::any('/OrderBind/{no}',  'UserController@OrderBind'); // 绑定的机器信息
    Route::get('/OrderThaw/{no}',  'UserController@Thaw');      // 订单金额解冻
    Route::get('/OrderSync/{no}',  'UserController@Sync');      // 订单金额解冻

});


/**
 * 支付宝扫码 创建订单路由  用户是通过支付宝的路由进入 支付宝APP 扫码进入
 */
##  支付测试




/**
 * @author [ pudding] <[< 755969423@qq.com >]>
 * @version [<vector>] [< 支付宝端扫码 >]
 */
Route::any('/Ali/{time}/{user}',        'AliController@index');                             // 扫码打开界面
Route::any('/auth/Ali/{time}/{user}',   'AliController@getUserInfo');                       // auth 授权后换区ACCTSS TOKEN




Route::any('/Ali/gateway/{platform?}',  'AliController@Gateway');       //支付宝网关
Route::any('/Ali/notify',               'AliController@orderNotify');   //授权订单异步回调

Route::get('/Ali/orderStatus/{orderNo}','AliController@orderStatus');   // 支付宝支付成功后的跳转页面



Route::post('/setName',                 'AliController@setName');       // 更改支付宝订单姓名






