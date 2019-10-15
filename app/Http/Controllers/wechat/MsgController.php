<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MsgController extends Controller
{
    public function push_tag_msg(Request $request){
        $id = $request->input('id');
        $token = WachatController::wechat();
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$token;
        $data=[
            "filter"=>[
            "is_to_all"=>false,
            "tag_id"=>$id
            ],
            "text"=>[
            "content"=>1111111
            ],
            "msgtype"=>"text"
        ];
        dd($data);
        $curl= CurlController::curlpost($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($curl,1);
        dd($result);

    }
}
