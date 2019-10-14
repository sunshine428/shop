<?php

namespace App\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Tools
{
    /** 根据openid获取用户的基本信息 */
//    public function get_wechat_user($openid){
//        $url='https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->get_assess_token().'&openid='.$openid.'&lang=zh_CN';
//        $re=file_get_contents($url);
//        $result=json_decode($re,1);
//        return $result;
//    }
    /** 获取微信access_token */
//    public function get_assess_token(){
//        $key='wechat_access_token';
//        //判断缓存是否存在
//        if(Cache::has($key)){
//            //取缓存
//            $wechat_access_token=Cache::get($key);
//        }else{
//            //取不到 调接口 缓存
//            $re=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.env('WECHAT_APPID').'&secret='.env('WECHET_SECRET'));
//            $res=json_decode($re,1) ;
//            Cache::put($key,$res['access_token'],$res['expires_in']);
//            $wechat_access_token=$res['access_token'];
//        }
//        return $wechat_access_token;
//    }
    public function wechat()
    {
        // dd($value);
        if(Cache::has('access_token')){
            $value = Cache::get('access_token');
        }else{
            $info = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx11872538a7dc69ad&secret=652c55528c551a597b6d2d764b8df1c8');
            $value = json_decode($info);
            Cache::put( 'access_token', $value->access_token, $value->expires_in);
            return $value->access_token;
        }
        return $value;
    }
    public function wechat_list()
    {
        $info = self::wechat();
        $user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token=$info&next_openid=");
        $user = json_decode($user,1);
        // $data = $user['data'];
        // $openid = $data['openid'];
        // dd($openid);
        $infos = [];
        foreach($user['data']['openid'] as $k=>$v){
            $userinfo = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=$info&openid=$v&lang=zh_CN");
            $infos[] = json_decode($userinfo,1);

        }
        return $infos;

    }

    public function getcurl($url){
//        $url="http://www.baidu.com";
        $curl=curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        $res=curl_exec($curl);
//        var_dump($res);
        curl_close($curl);
        return $res;
    }
    public function postcurl($url,$data){
//        $url="http://www.text.com/post/postcurl";
        $curl=curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);

        curl_setopt($curl,CURLOPT_POST,true);
//        $post_data=[
//            'name'=>222
//        ];
//        curl_setopt($curl,CURLOPT_POSTFIELDS,$post_data);
        $res=curl_exec($curl);
//        var_dump($res);
        curl_close($curl);
        return $res;
    }

}
