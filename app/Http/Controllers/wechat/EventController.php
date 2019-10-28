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
        //echo $_GET['echostr'];
        $info=file_get_contents("php://input");
        file_put_contents(storage_path('logs/wechat/'.date(  "Y-m-d").'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents(storage_path('logs/wechat/'.date("Y-m-d").'.log'),"$info\n",FILE_APPEND);
        $xml_obj=simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr=(array)$xml_obj;
        //dd($xml_arr);
        // 关注 回复
        $info = CurlController::getuser($xml_arr['FromUserName']);
        $user=UserintModels::where('openid','=',$xml_arr['FromUserName'])->first();
        $openid_info = OpenidModel::where(['openid'=>$xml_arr['FromUserName']])->first();
        if($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'subscribe'){
            //判断openid表是否有当前openid   生成的二维码
            if(empty($openid_info)){
                //首次关注
                if(isset($xml_arr['Ticket'])){
                    //带参数
                    $share_code = explode('_',$xml_arr['EventKey'])[1];
                    OpenidModel::insert([
                        'user_id'=>$share_code,
                        'openid'=>$xml_arr['FromUserName'],
                        'subscribe'=>1
                    ]);
                    UserModels::where(['user_id'=>$share_code])->increment('share_num',1); //加业绩
                }else{
                    //普通关注
                    OpenidModel::insert([
                        'user_id'=>0,
                        'openid'=>$xml_arr['FromUserName'],
                        'subscribe'=>1
                    ]);
                }
            }
            //========= 测试号关注=========
            if(!$user){
                UserintModels::insert([
                    'openid'=>$xml_arr['FromUserName'],
                    'name'=>$info['nickname'],
                    'add_time'=>time(),
                    'sign_num' =>'0',
                    'sign_day' =>'0',
                    'integral'=>'0'
                ]);
                $msg = '你好'.$info['nickname'].',欢迎关注我的公众号';
            }else{
                $msg = '欢迎回来'.$info['nickname'].',关注我的公众号';
            }
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }

        // 签到 回复
        if ($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'CLICK' && $xml_arr['EventKey'] == 'V1001_00') {
            //判断是否签到
            $today = date('Y-m-d',time()); //今天
            $last_day = date('Y-m-d',strtotime("-1 days")); //昨天
            if($user->sign_day == $today){
                // 已经签到
                $msg ="今日已签到";
            }else{
                // 签到
                $msg ="签到成功";
                //根据签到次数加积分
                //连续签到
                if($user->sign_day == $last_day){
                    // 连续签到
                    $sign_num = $user->sign_num +1;
                    if ($sign_num >= 6){
                        $sign_num =1;
                    }
                    UserintModels::where(['openid'=>$xml_arr['FromUserName']])->update([
                        'sign_day'=>$today,
                        'sign_num'=>$sign_num,
                        'integral'=>$user->integral + 5 * $sign_num
                    ]);
                }else{
                    // 非连续签到
                    UserintModels::where(['openid'=>$xml_arr['FromUserName']])->update([
                        'sign_day'=>$today,
                        'sign_num'=>1,
                        'integral'=>$user->integral + 5
                    ]);
                }
            }
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }

        // 积分查询
        if ($xml_arr['MsgType'] == 'event' && $xml_arr['Event'] == 'CLICK' && $xml_arr['EventKey'] == 'select_00'){
            $msg = "积分为".$user['integral']."";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }



        // 课程管理

        // 普通消息 回复
        if ($xml_arr['MsgType'] == 'text' && $xml_arr['Content'] == '1'){
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[有需要服务的吗？]]></Content></xml>";
        }else if ($xml_arr['MsgType'] == 'text' && $xml_arr['Content'] == '521'){
            $msg = "我爱你！";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }else if($xml_arr['MsgType'] == 'text' && $xml_arr['Content'] == '6'){
            $media_id ="tyXhwlo9Gh-761o1Fb6savT_RIhhLMcYXDpwUe8aJllFE2wNwMhwdEF7hHEoNd7u";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[voice]]></MsgType><Voice><MediaId><![CDATA[".$media_id."]]></MediaId></Voice></xml>";
        }else if($xml_arr['MsgType'] == 'text' && $xml_arr['Content'] == '8'){
            $media_id ="6cBYHyFtf74PI2o__6Uo0ErmgRPWevyLcA59PlFqtIhax__SImQlMoJ7pf3WdHXS";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[".$media_id."]]></MediaId></Image></xml>";
        }else if($xml_arr['MsgType'] == 'text' && $xml_arr['Content'] == '9'){
            $media_id ="mykIkSBhsIL2j3DNMTnCA2JS3GtrD_g076r0EQMofb4";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[video]]></MsgType><Video><MediaId><![CDATA[".$media_id."]]></MediaId><Title>"."遇见"."</Title><Description>"."我遇见谁会有怎样的对白,我等的人他在多远的未来,我听见风来自地铁和人海,我排著队拿著爱的号码牌"."</Description></Video></xml>";exit;
        }else{
            $msg = "纵情山河万里，肆意九州五岳！！！";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }






        /**
        //关注操作
        if($xml_arr['MsgType']=='event' && $xml_arr['Event']=='subscribe'){
            $wechat_user= CurlController::get_wechat_user($xml_arr['FromUserName']);
            $msg='你好'.$wechat_user['nickname'].'.欢迎注册我的公众号！';
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }
        //签到

        if($xml_arr['MsgType']=='event' && $xml_arr['Event']==''){

        }
        //普通消息  mydOj-jb_d42aJmKimJQtIKXe-pX-Q5MDYlz6NA87po9HRepeEvi7SaPmCDwNzsN
        if($xml_arr['MsgType']=='text' && $xml_arr['Content']=='222'){
            $msg="沙雕！！";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[".$msg."]]></Content></xml>";
        }else if($xml_arr['MsgType']=='text' && $xml_arr['Content']=='521'){
            $media_id="mydOj-jb_d42aJmKimJQtIKXe-pX-Q5MDYlz6NA87po9HRepeEvi7SaPmCDwNzsN";
            echo "<xml><ToUserName><![CDATA[".$xml_arr['FromUserName']."]]></ToUserName><FromUserName><![CDATA[".$xml_arr['ToUserName']."]]></FromUserName><CreateTime>".time()."</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[".$media_id."]]></MediaId></Image></xml>";
        }
         */
    }
}
