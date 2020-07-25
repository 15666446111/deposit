<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**
         * @var [type] [< 检测是否有登录Session >]
         */
        if (!$request->session()->has('users')) {
            return redirect('/login')->with(['error' => '您还未登录!']);
        }

        /**
         * @var [type] [< 验证用户是否存在 >]
         */
        return $next($request);
    }
}
