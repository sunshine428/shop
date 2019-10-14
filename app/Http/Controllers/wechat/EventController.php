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
        echo $_GET['echostr'];
    }
}
