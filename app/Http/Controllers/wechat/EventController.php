<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    /**
     *接受微信消息
     */
    public function event(){
        //echo $_GET['echostr'];
        $info=file_get_contents("php://input");
        file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
        file_put_contents(storage_path('logs/wechat/'.date('Y-m-d').'.log'),$info,FILE_APPEND);
        $xml_obj=simplexml_load_string($info,'SimpleXMLElement',LIBXML_NOCDATA);
        $xml_arr=(array)$xml_obj;
        dd($xml_obj);
    }
}
