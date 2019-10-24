<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
   public function wechat_menu(){
        return view('menu.wechatMenu');
   }
   /** 创建菜单 */
   public function create_menu(){

   }
   /** 菜单列表 */
   public function menu_list(){

   }
   /** 加载菜单 */
   public function load_meun(){
       $data=[
           "button"=>[
                [
                 "type"=>"click",
                  "name"=>"今日歌曲",
                  "key"=>"V1001_TODAY_MUSIC"
                 ],
            [
              "name"=>"菜单",
                   "sub_button"=>[
                       [
                           "type"=>"view",
                           "name"=>"搜索",
                           "url"=>"http://www.soso.com/"
                        ],
                        [
                            "type"=>"miniprogram",
                             "name"=>"wxa",
                             "url"=>"http://mp.weixin.qq.com",
                             "appid"=>"wx286b93c14bbf93aa",
                             "pagepath"=>"pages/lunar/index"
                         ],
                        [
                            "type"=>"click",
                           "name"=>"赞一下我们",
                           "key"=>"V1001_GOOD"
                        ]
                    ]
                 ]
            ]
    ];
       $token=CurlController::get_access_token();
       $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token;
       $re=CurlController::curlpost($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        dd($re);
   }

}
