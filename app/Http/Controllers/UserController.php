<?php

namespace App\Http\Controllers;

use App\User;
use App\Zfconfig;
use Illuminate\Http\Request;
use App\Packages\Alipay\AlipayCli;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function qrcode(Request $request)
    {

        $type =2;  // 1，微信 2.支付宝(默认)

        // * 获得当前用户生成的二维码地址
        $HOST = $_SERVER['HTTP_HOST'];

        // * 生成URL 邀请地址
        $WeHOST = "http://" . $HOST . "/We/" . time() ."/". encrypt($request->session()->get('users.username'));

        Log::info("session 用户name:".$request->session()->get('users.username'));

        // * 生成URL 邀请地址
        $AliHOST= "http://" . $HOST . "/Ali/" . time() ."/". encrypt($request->session()->get('users.username'));
        // 提前准备好的支付宝背景图  必须是PNG格式
        $bgpic = public_path().DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR.'bg.png';    
        //保存合成图片的路径地址
        $file = DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "public" .DIRECTORY_SEPARATOR ."qrcode" .DIRECTORY_SEPARATOR ;  
        // 如果路径不存在 则创建该地址
        if (!file_exists(storage_path($file))) {
            mkdir(storage_path($file), 0777, true);
        }
        if($type ==1){
            $url = $WeHOST;
            $path = $file . DIRECTORY_SEPARATOR .session('users.username')."wechat.png";
        }else{
            $url = $AliHOST;
            $path = $file . DIRECTORY_SEPARATOR .session('users.username')."ali.png";
        }
        //生成二维码图片
        QrCode::format('png')->errorCorrection('L')->size(200)->margin(0)->generate($url, storage_path($path));
        // 图片合成
        $bg = imagecreatefrompng($bgpic);             // 提前准备好的背景图  必须是PNG格式
        $qrcodes = imagecreatefrompng(storage_path($path)); // 生成的二维码图片
       // $x = imagesx($bg); //二维码开始位置的x坐标
       // $y = imagesy($bg); //二维码开始位置的x坐标
        imagecopyresampled($bg, $qrcodes, 125, 280, 0, 0, imagesx($qrcodes), imagesx($qrcodes), imagesx($qrcodes), imagesx($qrcodes));
        $res = imagepng($bg, storage_path($path)); //合并图片
       // return response()->json($qrcode);
        return view('code', compact('WeHOST', 'AliHOST'));
    }



    /**
     * [AccountList 业务帐号列表]
     * @author Pudding 2019-09-26
     * @param  Request $request [description]
     */
    public function AccountList(Request $request)
    {
        try{
        // 新增业务帐号
        if((session('users'))->platform_role!='system' && (session('users'))->platform_role!='administer' && (session('users'))->isLeader!=1){
            return redirect(url()->previous())->withErrors('没有相关权限');
        }
        //  $request->isMethod('post')
        if($request->isMethod('post'))
        {
            $validator = Validator::make($request->all(), [
                'username'  => ['required', 'regex:/^1[3456789][0-9]{9}$/', 'unique:users,username'],
                'password'  => ['required', 'string', 'min:6'],
                'platform' => ['required'],
                'name'      => ['required']
            ], [
                'username.required' =>  '请填写帐号!',
                'username.regex'    =>  '帐号需要为手机号格式!',
                'username.unique'   =>  '业务帐号已存在!',
                'password.required' =>  '请设置密码!',
                'password.string'   =>  '密码为字符串类型!',
                'password.min'      =>  '密码最小需要6位字符',
                'name.required'     =>  '请填写姓名!',
                'platform.required'      =>  '请填写管理员所属商户!',
            ]);
            if($validator->fails()){
                return redirect('AccountList')->withErrors($validator->errors());
            }
            $role = "member";
            $platform = session()->get('users.platform');
            if(session()->get('users.platform_role')=='system'){
                $role = "administer";
                $platform =  $request->platform;
            }
            ## 如果当前会员是组员
            $isLeader = 0;
            if(session()->get('users.isLeader')!=1 && (session()->get('users.platform_role')=='system' || session()->get('users.platform_role')=='administer')){
                $isLeader =  $request->isLeader;
            }
            ## 如果当前会员是 组长，只能添加当前组别的的会员
            $user = \App\User::create([
                'username'  =>      $request->username,
                'password'  =>      Hash::make($request->password),
                'name'      =>      $request->name,
                'platform'      =>  $platform,
                'platform_code' =>  '1',//暂时不设定
                'platform_role' => $role,
                'groups' =>  $request->groups,
                'isLeader' =>  $isLeader,
                'email'     =>      $request->email ?? '',
            ]);

            return redirect('/AccountList')->with(['success'=> '添加成功!']);
        }
        $list = \App\User::withCount('orderMany');
        ## 获取当前登陆会员的平台信息
        if(session()->get('users.platform_role') == "system"){
            ##显示全部 administer信息
            $lists = $list->orderBy('created_at', 'DESC')->paginate(15);
        }else if(session()->get('users.platform_role')=="administer"){
            ## 只显示当前平台下
            $lists = $list->where('platform',session()->get('users.platform'))->orderBy('created_at', 'DESC')->paginate(15);
        }else if((session('users'))->isLeader==1){
            ## 只显示当前组别的
            $lists = $list->where('platform',session()->get('users.platform'))->where('groups',session()->get('users.groups'))->orderBy('created_at', 'DESC')->paginate(15);
        }
        return view('AccountList', compact('lists'));
        }catch(Exception $error){
            dd($error->getMessage());
        }
    }



    ## 账号禁用
    public function ban_account(Request $request){
        try{
            $account = $request->account;
            $user = User::where('id',$account)->firstOrFail();
            if($user->status==0){
                $user->status = 1;
            }else{
                $user->status = 0;
            }
            $user->save();
            return redirect()->route('AccountList')->withErrors('账号状态已经更改');
        }catch(Exception $error){
            dd($error->getMessage());
        }
    }

    
    /**
     * [resetPass 重置密码]
     * @author Pudding 2019-09-26
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function resetPass(Request $request)
    {
        if($request->isMethod('post'))
        {
            if(!$request->session()->get('users.username')) return redirect('/login')->with(['error'=>'请先登录!']);

            $validator = Validator::make($request->all(), [
                'oldpass' => ['required' ],
                'newpass' => ['required', 'string', 'min:6'],
                'conpass' => ['required'],
            ], [
                'oldpass.required' =>  '请填写原密码!',
                'newpass.required' =>  '请填写新密码!',
                'newpass.string'   =>  '密码为字符串类型!',
                'newpass.min'      =>  '密码最低6位字符!',
                'conpass.required' =>  '请填写确认密码!',
            ]);

            if($validator->fails()) return redirect('/resetPass')->with(['error'=> $validator->errors()->first()]);

            if($request->newpass != $request->conpass) return redirect('/resetPass')->with(['error'=>'两次密码不一致!']);

            if(!Hash::check($request->oldpass, $request->session()->get('users.password'))) return redirect('/resetPass')->with(['error'=>'旧密码错误!']);

            $user = \App\User::where('id', $request->session()->get('users.id'))->first();

            $user->password = Hash::make($request->newpass);

            $user->save();

            $request->session()->put('users',  $user);

            return redirect('/resetPass')->with(['success'=>'密码修改成功!']);
        }

        return view('resetPass');
    }

    /**
     * [loginOut 退出登录]
     * @author Pudding 2019-09-26
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function loginOut(Request $request)
    {
        $request->session()->flush();

        return redirect('/');
    }

    /**
     * [Aliorder 我的支付宝订单]
     * @author Pudding 2019-09-25
     * @param  Request $request [description]
     */
    public function Aliorder(Request $request)
    {

        // == 获取搜索参数
        $where = $request->input();
        $where['order_parent']= $request->route('order_parent'); //查询业务员下订单条件
        //DB::connection()->enableQueryLog();  // 开启QueryLog
        // == 定义查询构造器
        ## 获取当前登陆会员的平台信息
        if(session()->get('users.platform_role') == "system"){
            ##显示全部
            $Query = \App\Order::with('toBind');
        }else if(session()->get('users.platform_role')=="administer"){
            ## 只显示当前平台下
            $members = User::where('platform',session()->get('users.platform'))->get();
            $Query = \App\Order::with('toBind')->whereIn('order_parent', $members->pluck('username'));
        }else if(session()->get('users.platform_role')=="member" && session()->get('users.isLeader')==1){
            ## 只显示当前组别下
            $members = User::where('groups',session()->get('users.groups'))->get();
            $Query = \App\Order::with('toBind')->whereIn('order_parent', $members->pluck('username'));
        }else{
            ## 只显示自己的
            $Query = \App\Order::with('toBind')->where('order_parent', $request->session()->get('users.username'));
        }


        # 闭包函数搜索
        $Query  = $Query->where(function ($Query) use ($where)
        {
            if(isset($where['order_parent']) and $where['order_parent']!= null){
                $Query->where('order_parent','=',$where['order_parent']);
            }

            if(isset($where['username']) and $where['username']!= null){
                $username = \App\User::where('name', 'like', '%' . $where['username'] . '%')->value('username');
                $Query->where('order_parent','=',$username);
            }
            if(isset($where['ORDER']) and $where['ORDER']!= null)
                $Query->where('order_no', 'like', '%' . $where['ORDER'] . '%');
            if(isset($where['NICKNAME']) and $where['NICKNAME']!= null)
                $Query->where('order_user_name', 'like', '%' . $where['NICKNAME'] . '%');

            if(isset($where['bind_sn']) and $where['bind_sn']!= null)
            {
                $Query->whereHas('toBind', function($Query) use ($where){
                    $Query->where('bind_sn', 'like', '%' . $where['bind_sn'] . '%');
                    $Query->orWhere('bind_merch', 'like', '%' . $where['bind_sn'] . '%');
                });
            }

            if(isset($where['PAY']) and $where['PAY']!= 'all')
            {
                $where['PAY'] == '1' ? $Query->whereNotNull('alipay_payer_logon') : $Query->whereNull('alipay_payer_logon');
            }

            if(isset($where['thaw']) and $where['thaw']!= 'all')
            {
                if($where['thaw'] == '1') $Query->where('total_unfreeze_amount', '>', '0');

                if($where['thaw'] == '0') $Query->where('total_unfreeze_amount', '0');
            }

            if(isset($where['payer']) and $where['payer']!= 'all')
            {
                if($where['payer'] == '1') $Query->where('total_pay_amount', '>', '0');

                if($where['payer'] == '0') $Query->where('total_pay_amount', '0');
            }

        });

        $list = $Query->orderBy('created_at', 'DESC')->paginate(10);
        foreach($list as $key =>$val){
            $parent_name = \App\User::where(['username'=>$val['order_parent']])->value('name');
            $val['parent_name']=$parent_name;
        }
        return view('AliMyOrder', compact('list', 'where'));
    }

    /**
     * [OrderBind 绑定的机器信息]
     * @author Pudding 2019-09-29
     * @param  Request $request [description]
     */
    public function OrderBind(Request $request)
    {
        if(!$request->route('no')) abort(404);

        $no = $request->route('no');

        if($request->isMethod('post'))
        {
            if(!$request->bind_title) return redirect('/OrderBind/'.$no)->with(['error' => '请填写机器型号']);
            //if(!$request->bind_merch) return back()->with(['error' => '请填写机器的商户编号']);
            if(!$request->bind_sn) return redirect('/OrderBind/'.$no)->with(['error' => '请填写机器的终端号']);

            $bind = \App\OrderBind::where('bind_no', $request->route('no'))->first();
            if(empty($bind))
            {
                $bind = \App\OrderBind::create([
                    'bind_no'   =>  $no,
                    'bind_title'=>  $request->bind_title,
                    'bind_sn'   =>  $request->bind_sn,
                    'bind_merch'=>  isset($request->bind_merch) ? $request->bind_merch : '',
                    'bind_active' => isset($request->bind_active) ? $request->bind_active : 0,
                ]);
            }else{
                $bind->bind_sn = $request->bind_sn;
                $bind->bind_title = $request->bind_title;
                $bind->bind_merch = isset($request->bind_merch) ? $request->bind_merch : '';
                $bind->bind_active= isset($request->bind_active) ? $request->bind_active : 0;
                $bind->save();
            }


            return redirect('/OrderBind/'.$no)->with(['success' => '机器绑定信息确认成功!']);
        }


        $bind = \App\OrderBind::where('bind_no', $request->route('no'))->first();

        return view('order.bind', compact('bind', 'no'));
    }

    /**
     * [Thaw 订单金额解冻]
     * @author Pudding 2019-09-29
     * @param  Request $request [description]
     */
    public function Thaw(Request $request)
    {
        if(!$request->route('no')) return json_encode(['code' => 9999, 'msg'=> '缺少业务参数!']);
        $order = \App\Order::where('order_no', $request->route('no'))->first();

        if(!$order or empty($order)) return json_encode(['code' => 9998, 'msg'=> '订单不存在!']);
        ## 通过订单找到人 在找到平台
        $config = Zfconfig::where('platform_code',$order->platform)->firstOrFail();
        // 去调用预授权资金解冻
        /**
         * @var [type] [< 创建解冻订单>]
         */
        $thaw = \App\OrderThaw::create([
            'auth_no'   =>  $order->alipay_auth_no,
            'out_request_no'    =>  'THAW'.$this->build_rand_no(),
            'thaw_amount'   =>  $order->order_amount,
            'remark'        =>  '预授权资金解冻',
        ]);
        ## 查询当前用户所属的平台
        $user =
        // -- 调用客户端
        $reponse = new AlipayCli($config);
        // -- 预授权资金解冻
        $ThawReponse  = $reponse->ThawOrder($thaw);
        $thaw->bak = json_encode($ThawReponse);

        $thaw->save();

        if($ThawReponse->code != 10000) return json_encode(['code' => 9995, 'msg'=> $ThawReponse->sub_msg]);

        $thaw->out_order_no = $ThawReponse->out_order_no;

        $thaw->operation_id = $ThawReponse->operation_id;

        $thaw->gmt_trans    = $ThawReponse->gmt_trans;

        $thaw->status       = $ThawReponse->status;

        $thaw->credit_amount= isset($ThawReponse->credit_amount) ? $ThawReponse->credit_amount * 100 : '0';

        $thaw->fund_amount  = isset($ThawReponse->fund_amount) ? $ThawReponse->fund_amount * 100 : '0';

        $thaw->save();

        /**
         * @var [type] [< 设置订单里面的冻结金额>]
         */
        $order->total_unfreeze_amount = $order->total_unfreeze_amount + ($ThawReponse->amount * 100);

        $order->rest_amount           = $order->rest_amount - ($ThawReponse->amount * 100);

        $order->save();

        return json_encode(['code' => 10000, 'msg'=> '该订单资金已解冻!']);

    }

    /**
     * [Sync 订单和支付宝订单信息同步]
     * @author Pudding
     * @DateTime 2019-10-12T19:28:32+0800
     * @param    Request                  $request [description]
     */
    public function Sync(Request $request)
    {

        if(!$request->route('no')) return json_encode(['code' => 9999, 'msg'=> '缺少业务参数!']);

        $order = \App\Order::where('order_no', $request->route('no'))->first();

        if(!$order or empty($order)) return json_encode(['code' => 9998, 'msg'=> '订单不存在!']);

        // -- 调用客户端
        $reponse = new AlipayCli();

        // -- 预授权资金解冻
        $SyncReponse  = $reponse->SyncOrder($order);

        dd($SyncReponse);

    }


    /**
     * [build_rand_no 生成订单号]
     * @author Pudding 2019-09-25
     * @return [type] [description]
     */
    public function build_rand_no()
    {
        mt_srand((double) microtime() * 1000000);
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
}
