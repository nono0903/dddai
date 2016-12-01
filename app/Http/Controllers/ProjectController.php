<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pro;
use App\Att;
use App\Bid;
use App\User;
use Auth;
use DB;



class ProjectController extends Controller
{ //在本控制器上绑定中间件,实现登录用户访问权限允许的页面
   protected $middleware = ['App\Http\Middleware\Authenticate'=>[]];

   public function jie(){
    return view('woyaojiekuan');
   }

   public function jiepost(Request $req){
    
    
    $user = $req->user();
    $pro = new \App\Pro();
    $att = new \App\Att();
    //projects表数据
    $pro->uid = $user->uid;
    $pro->name = $user->name;
    $pro->mobile = $req->mobile;
    $pro->money = $req->money*100;
    $pro->pubtime = time();

    $pro->save();

    //atts表数据
    $att->uid = $user->uid;
    $att->pid = $pro->pid;
    $att->age = $req->age;
    $att->save();
   return 'ok';

   }
   public function pro($pid){
    $pro = Pro::find($pid);

    return view('lijitouzi',['pro'=>$pro]);
   }

   public function postpro(Request $req ,$pid){
    dd($user);
      $pro = Pro::find($pid);
      $bid = new Bid();
      $user = Auth::user();

      
      if($pro->money-$pro->recive>=$req->touzi){
      $bid->uid = $user->uid;
      $bid->pid = $pro->pid;
      $bid->title = $pro->title;

      $bid->money = $req->touzi*100;
      $bid->pubtime = time();
      $bid->save();
      //修改项目表投资信息
      // $pro->recive += $req->touzi;
      // $pro->save();
      $pro->increment('recive',$bid->money);
      }else{
        echo "请填写正确的金额";
        
      }
      if($pro->recive==$pro->money){//当收到的投资金额等于招标金额,吊用投资已满方法
        //修改pro表status信息;
        echo'投资已满!';
        $this->touzidone($pid);
      }
      //投资表信息
     
   }

   public function touzidone($pid){
      $pro = Pro::find($pid);
      $pro->status  = 2;
      $pro->save();
      //生成还款信息
      $amount = ($pro->money*$pro->rate/1200)+($pro->money/$pro->hrange);

    $row=['uid'=>$pro->uid,'pid'=>$pro->pid,'title'=>$pro->title];
    $row['amount'] = $amount;
    $row['status'] = 0;

    $today = date('Y-m-d',time());
    for ($i=1; $i<=$pro->hrange ; $i++) { 
      $row['paydate'] = date('Y-m-d',strtotime('+'. $i. 'months'));

      DB::table('hks')->insert($row);
    }

    $bids = Bid::where('pid',$pid)->get();
    $taskinfo = [];
    $taskinfo['pid'] = $pid;
    $taskinfo['title'] = $pro->title;
    $taskinfo['enddate'] = date('Y-m-d',strtotime("+ {$pro->hrange} months"));

    foreach ($bids as $v ) {
      $taskinfo['uid'] = $v->uid;
      $taskinfo['amount'] = ($v->money*$pro->rate )/36500;
      DB::table('tasks')->insert($taskinfo);
    }
   }

   public function myzd(){
      $zd = DB::table('hks')->get();
    return view('myzd',['zd'=>$zd]);
   }

   public function mytz(){
    $user = Auth::user();

    // dd($user);
    $tz = Bid::where('bids.uid',$user->uid)->whereIn('status',[1,2])->join('projects','bids.pid','=','projects.pid')->get(['bids.*','projects.status']);

     // dd($tz);

    return view('mytz',['tz'=>$tz]);
   }

   public function mysy(){
    $user = Auth::user();
     $sy = DB::table('grows')->where('grows.uid',$user->uid)->orderBy('gid','desc')->get();

    // $sy = ['gid'=>1,'uid'=>2,'pid'=>3,'title'=>4,'amount'=>5,'paytime'=>6];
    return view('mysy',['sy'=>$sy]);
   }


   public function mydk(){
     $user = Auth::user();
     $zd = Pro::where('projects.uid',$user->uid)->get();

    return view('mydk',['dk'=>$zd]);
   }

   public  function pay(Request $req ){
    $pro['pid'] =$req->pid ;
    $pro['title'] =$req->title;
     
   $payinfo=array();
   $payinfo['v_amount'] = $req->touzi;//订单总金额
   $payinfo['v_moneytype'] = "CNY";//订单币种
   $payinfo['v_oid'] =date('ymd').mt_rand(9999,99999); //订单编号
   $payinfo['v_mid'] = '20272562';//商户编号
   $payinfo['v_url'] = "http://ddd.com/payback";//完成后返回值地址
   $payinfo['key'] = '%()#QOKFDLS:1*&U';
   $payinfo['v_md5info'] = strtoupper(md5(implode('',$payinfo)));
   $payinfo['pid'] = $req->pid;
   $payinfo['title'] = $req->title;
   // dd($payinfo);
    return view('pay',$payinfo);
   }

   public function payback(Request $req){
    if($req->v_pstatus==30){
        return '支付失败';
    }elseif($req->v_pstatus==20){
    $back['v_oid'] = $req->v_oid;
    $back['v_pstatus'] = $req->v_pstatus;
    $back['v_amount'] = $req->v_amount;
    $back['v_moneytype'] = $req->v_moneytype;
    $back['key'] = '%()#QOKFDLS:1*&U';
    $back['v_md5info'] = strtoupper(md5(implode('',$back)));
    $back['v_pstring'] = $req->v_pstring;
    $back['v_pmode'] = $req->v_pmode;

    if($back['v_md5info'] == $req->v_md5str){
        echo 支付失败;
    }
  }
    dump($req->v_md5str);
    dump($back);
    dd($_POST);
   }


}
/*<input type=hidden name=v_mid value="20000400">                    商户编号
<input type=hidden name=v_oid value="19990720-20000400-000001234">订单编号
<input type=hidden name=v_amount value="0.01">                订单总金额
<input type=hidden name=v_moneytype value="CNY">                币种
<input type=hidden name=v_url value="http://domain/chinabank/Receive.asp">
支付动作完成后返回到该url，支付结果以POST方式发送
<input type=hidden name=v_md5info value="1630DC083D70A1E8AF60F49C143A7B95">                 订单MD5校验码*/

