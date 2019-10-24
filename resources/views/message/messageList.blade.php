@extends('layout.layout')

@section('title')
    留言页面
@endsection

@section('content')
    <form action="{{ url('/wechat/addsign') }}" method="post">
        <input type="hidden" name="id" value="{{ $id }}">
        <table class="layui-table" border="1" cellspacing="0">
            <thead>
            <tr>
                <th style="width:50px;height: 60px;text-align: center">编号</th>
                <th style="text-align: center">openid：</th>
                <th style="text-align: center">用户名：</th>
                <th style="text-align: center;width:80px;height: 60px">性别：</th>
                <th style="text-align: center;width:80px;height: 60px">头像：</th>
                <th style="text-align: center">地区：</th>
                <th style="text-align: center">关注时间：</th>
                <th style="text-align: center;width:120px;height: 60px">所属标签：</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $k=>$v)
                <tr>
                    <td align="center"><input type="checkbox" name="openid_list[]" value="{{ $v['openid'] }}"></td>
                    <td align="center">{{ $v['openid'] }}</td>
                    <td align="center">{{ $v['nickname'] }}</td>
                    <td align="center">@if($v['sex']==1)男@else女@endif</td>
                    <td align="center"><img src="{{ $v['headimgurl'] }}" alt="" width="50"></td>
                    <td align="center"> {{ $v['country']  }} {{ $v['province'] }} {{ $v['city']  }}</td>
                    <td align="center">{{ date("Y:m:d H:i:s",$v['subscribe_time']) }}</td>
                    <td align="center"><a href="/wechat/message?openid={{ $v['openid'] }}">单条留言</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <button style="width:150px;height:30px;background: darkblue;text-align: center;border-radius: 10px; margin-left: 300px;">群发</button>
    </form>
@endsection
