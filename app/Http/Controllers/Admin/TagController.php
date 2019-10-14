<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;

class TagController extends Controller
{
    public $tools;
    public function __construct(Tools $tools){
        $this->tools=$tools;
    }
    public function tag_list(){
        //公众号标签列表
        $url='https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->tools->wechat();
        $re= $this->tools->getcurl($url);
        $res=json_decode($re,1);
        dd($res);
    //        return view("admin.Tag.tagList",['data'=>$res['tags']]);
    }
    public  function add_tag(){
        return view("admin.Tag.addTag");
    }
    public function do_add_tag(Request $request){
        echo 111;
    }
}
