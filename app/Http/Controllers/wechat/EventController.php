<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\wechat\CurlController;
use App\Weui\UserintModels;
use App\Weui\OpenidModel;
use App\Models\UserModels;
class EventController extends Controller
{
    /**
     *接受微信消息
     */
    public function event(){
        $info=file_get_contents("php://input");
        file_put_contents(storage_path('logs/wechat/'.date("Y-m-d").'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n".FILE_APPEND);
        file_put_contents(storage_path('logs/wechat/'.date("Y-m-d").'.log'),"$info\n",FILE_APPEND);
        $xml_obj=simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr=(array)$xml_obj;
        //关注 回复
        if($xml_arr['MsgType']=='event' && $xml_arr['Event']=='subscribe'){
            $wechat_info=CurlController::get_wechat_user($xml_arr['FromUserName']);
            if($wechat_info['sex'] == 2){
                $nv ="美女";
            }else{
                $nv= "帅哥";
            }
            $msg='您好,'.$wechat_info['nickname'].$nv.',欢迎关注我的公众号!';
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";

        }
    }
}
