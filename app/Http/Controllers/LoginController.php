<?php
/**
 * ZNHGJ - A PHP Project For Web Artisans
 * @version  [1.0.0] [<description>]
 * @package  Laravel
 * @link     www.lianshuopay.com
 * @author   Pudding <755969423.com>
 * @param    [type] [name] [<description>]
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Check User Login.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if($request->session()->has('users')){
                return redirect('/');
            }
            return $next($request);
        });
    }


    /**
     * [index 显示用户登录页面]
     * @author Pudding 2019-09-21
     * @return [type] [description]
     */
    public function index()
    {

        return view('auth.login');
    }

    /**
     * [check 用户登录验证]
     * @author Pudding 2019-09-21
     * @return [type] [description]
     */
    public function checkValation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'regex:/^1[3456789][0-9]{9}$/', 'exists:users,username' ],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'username.required' =>  '请填写登录用户名!',
            'username.regex'    =>  '登录帐号必须为手机号!',
            'username.exists'   =>  '帐号不存在!',
            'password.required' =>  '请填写您的密码!',
            'password.string'   =>  '密码为字符串类型!',
            'password.min'      =>  '密码不正确!',
        ]);

        if ($validator->fails()) return $this->redirectTo($validator->errors()->first());

        $user = \App\User::where('username', $request->username)->first();
        if($user->status!=1) return $this->redirectTo('账号已停用!');
        if(!Hash::check($request->password, $user->password)) return $this->redirectTo('密码错误!');
        $request->session()->put('users',  $user);
        return redirect('/');
    }

    /**
     * [redirectTo description]
     * @author Pudding 2019-09-21
     * @param  [type] $msg [description]
     * @return [type]      [description]
     */
    private function redirectTo( $msg = null)
    {
        return $msg ? redirect('/login')->with(['error' => $msg]) : redirect('/login');
    }
}
