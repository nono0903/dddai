<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pro;

class IndexController extends Controller
{
    public function index(){
        $list = Pro::where('status',1)->take(3)->get();
        
        return view('index',['list'=>$list]);
    }
}
