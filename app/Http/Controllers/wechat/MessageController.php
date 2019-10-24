<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CsUser;

class MessageController extends Controller
{
    //微信授权登录
    public function wechat_message_login(){
      return view('message.messageLogin');
    }
    // 用户授权
    public function userinfo()
    {
//        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $app = urlencode(env('APP_URL')."/wechatcode");
        // 第一步：用户同意授权，获取code
        $url = "location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECGAT_APPID')."&redirect_uri=$app&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        header($url);
    }

    //  第二步 通过code换取网页授权access_token
    public function wechatcode(Request $request)
    {
        $code = request()->input('code'); // 得到code

        $token = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECGAT_APPID')."&secret=".env('WECHET_SECRET')."&code=".$code."&grant_type=authorization_code");
        $userinfo = json_decode($token,1);
//        dd($userinfo);
        $openid=$userinfo['openid'];
      //存session
        session()->put(['userinfo',$userinfo]);
        return redirect('/wechat/message_list');
    }
    public function message_list(Request $request){
            $id = $request->input('id');
            // 获取 asess_token
            $token = WachatController::wechat();
            // 获取open_id
            $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$token."&next_openid=";
            // 获取 所有 粉丝
            $getsign = CurlController::curlget($url);
            $fans = json_decode($getsign, true, JSON_UNESCAPED_UNICODE);
            // 获取 所有 粉丝 信息
            $data = [];
            foreach($fans['data']['openid'] as $k=>$v){
                $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$v."&lang=zh_CN";
                $getsign = CurlController::curlget($url);
                $data[] = json_decode($getsign, true, JSON_UNESCAPED_UNICODE);
            }
            // 所属 标签
//        $this->indexsign($fans['data']['openid']);
            return view('message.messageList',['data'=>$data,'id'=>$id]);
        }
        //单条留言
        public function message(Request $request){
            $data = $request->input('openid');
            $token = WachatController::wechat();
            $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$token;
            $data = [
                'touser'=>$data,
                'template_id'=>'hlDpL68NcT7JBai6MTcXlf5j99-UdMyUnaS2eGh3-xo',
                'data'=>[
                    'keyword1'=>[
                        'value'=>'用户',
                        'color'=>''
                    ],
                    'keyword2'=>[
                        'value'=>'洗发水',
                        'color'=>''
                    ]
                ]
            ];
            $arr = json_encode($data, JSON_UNESCAPED_UNICODE);
            $fans = CurlController::curlpost($url,$arr);
            $data = json_decode($fans, true, JSON_UNESCAPED_UNICODE);
            dd($data);
        }
        //群发留言
    public function messages(){

    }
}
