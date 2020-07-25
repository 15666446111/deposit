<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Packages\Alipay2\Aop\AopClient;
use App\Packages\Alipay2\HttpRequest;
use App\Packages\Alipay2\GetConfig;
use App\Packages\Alipay2\Gateway;

class AliOrderController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        dd($request);
    }

}