<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurlController extends Controller
{
    // get 请求
    public static function curlget($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    // post 请求
    public static function curlpost($url,$data)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    // 标签 列表
    public static function curlindex()
    {
        $token = WachatController::wechat();
        $url = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$token;
        $getsign = CurlController::curlget($url);
        $sign = json_decode($getsign, true, JSON_UNESCAPED_UNICODE);
        return $sign;
    }
    // 获取taken
    public static function get_access_token()
    {

        if(\Cache::has('access_token')){
            $value = \Cache::get('access_token');
        }else{
            $info = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx11872538a7dc69ad&secret=652c55528c551a597b6d2d764b8df1c8');
            $value = json_decode($info);
            \Cache::put('access_token', $value->access_token, $value->expires_in);
            return $value->access_token;
        }
        return $value;
    }
    public static function get_wechat_user($openid){
        $data = self::get_access_token();
        $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$data.'&openid='.$openid.'&lang=zh_CN';
        $re=file_get_contents($url);
        $result=json_decode($re,1);
        return $result;
    }

    /**
     *文件资源---临时素材

    public static function wechat_curl_file($url,$path)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_POST,true);
        $data=[
            'media'=>new \CURLFile(realpath($path))
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    } */
    /**
     *文件资源---永久素材
     */
    public static function wechat_curl_file($url,$data)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_POST,true);

        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
    // 粉丝信息
    public static function getuser($openid)
    {
        $token = self::get_access_token();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$openid.'&lang=zh_CN';
        $re = file_get_contents($url);
        $result = json_decode($re,1);
        return $result;
    }
    // 验 签
    public static function sdk()
    {
        $token = self::get_access_token();
        $key = 'sdk';
        //判断缓存是否存在
        if(\Cache::has($key)) {
            //取缓存
            $sdk = \Cache::get($key);
        }else{
            //取不到，调接口，缓存
            $re = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token.'&type=jsapi');
            $result = json_decode($re,true);
            \Cache::put($key,$result['ticket'],$result['expires_in']);
            $sdk = $result['ticket'];
        }
        return $sdk;
    }
    public function aaa(){
        $token=CurlController::get_access_token();
        $url="https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=".$token;
        $data=json_encode(['appid'=>env("WECGAT_APPID")]);
        $res=CurlController::curlpost($url,$data);
        $res=json_decode($res);
//        return $res;
        dd($res);
    }

}
