<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RedisController extends Controller
{
    public function index(){
       $value = Cache::get('token');
       if(empty($value)){
           $info=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET');
           $value=json_decode($info);
//           dd($value);
           Cache::put('token',$value->access_token,$value->expires_in);
           dd("接口".$value->access_token);
       }
        dd("redis".$this->get_wechat_token());
    }
    // 方法
    public function get_wechat_token()
    {
        $id = \Cache::get('token');
        // dd($id);
        return $id;
    }

}
