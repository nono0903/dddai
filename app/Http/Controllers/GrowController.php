<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class GrowController extends Controller
{
    public function run(){//执行一个查询的方法将每一个用户所得收益发放出来
    	$today = date('Y-m-d',time());//拟定today发放的时间

    	$tasks = DB::table('tasks')->where('enddate','>=',$today)->get();//取出预期收益表里的需要发放的信息,计算并循环打印每个用户收益时间,

    	foreach ($tasks as $v) {
    	// $growinfo['uid'] = $v->uid;
    	// $growinfo['pid'] = $v->pid;
    	// $growinfo['title'] = $v->title;
    	// $growinfo['amount'] = $v->amount/;
        $v->paytime = $today;
        $v = (array)$v;
        unset($v['tid']);
        unset($v['enddate']);
        DB::table('grows')->insert($v);
    	}
    }
}
