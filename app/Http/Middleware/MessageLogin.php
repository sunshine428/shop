<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
//
class MessageLogin
{
    public function handle($request, Closure $next)
    {
        //验证是否登录

        if ($request->session()->has('userinfo')) {
            return redirect("/wechat_message_login");
        }
        return $next($request);
    }
}
