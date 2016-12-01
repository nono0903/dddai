<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pro;
use App\Att;


class CheckController extends Controller
{
    public function prolist(){
        $pro = new \App\Pro();
        $prolist = $pro->all();
        return view('prolist',['list'=>$prolist]);
    }

    public function shenhe($id){
        $pro = Pro::find($id);
        $att = Att::where('pid',$id)->first();

        if(empty($pro)){
            return redirect('/prolist');
        }
        return view('shenhe',['pro'=>$pro,'att'=>$att ]);      
    }

    public function postshenhe(Request $req,$id){
        // dd($_POST);
        $pro = Pro::find($id);
        $att = Att::where('pid',$id)->first();
        
        $pro->title = $req->title;
        $pro->rate = $req->rate;
        $pro->status = $req->status;
        $pro->hrange = $req->hrange;

        $att->title = $req->title;
        $att->realname = $req->realname;
        $att->jobcity = $req->jobcity;
        $att->udesc = $req->udesc;
        $att->salray = $req->salary;
        $att->gender = $req->gender;

        if ($pro->save()&&$att->save()) {
            return redirect('/prolist');
        }else{
            return 'error';
        }
    }



}
