@extends('layout.layout')

@section('title')
    品牌 展示
@endsection


@section('content')
<div align="center">
    <h2>标签列表</h2>
</div>
<br>
<div align="center">
    <button style="background: orchid;"><a href="/wechat/sign" style="color:#ffffff;text-decoration: none">增加标签</a></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button style="background: palevioletred;"><a href="/wechat/fans" style="color:#ffffff;text-decoration: none">粉丝列表</a></button>
</div>
<br>
<table class="layui-table" border="1" align="center">
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th align="center" style="text-align: center">编号</th>
        <th align="center" style="text-align: center">名称</th>
        <th align="center" style="text-align: center">操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sign as $k=>$v)
        <tr>
            <td align="center">{{$v['id']}}</td>
            <td align="center">{{$v['name']}}</td>
            <td align="center" style="color: palevioletred">
                <a href="/wechat/delsign?id={{ $v['id'] }}" style="color:mediumslateblue">删除标签</a> ||
                <a href="/wechat/updatesign?id={{ $v['id'] }}&name={{$v['name']}}" style="color:cadetblue">修改标签</a> ||
                <a href="/wechat/tagfans?id={{ $v['id'] }}" style="color:darkblue">标签粉丝</a> ||
                <a href="/wechat/fans?id={{ $v['id'] }}" style="color:steelblue">为粉丝打标签</a>||
                <a href="/wechat/push_tag_msg?id={{ $v['id'] }}" style="color:steelblue">发送消息</a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
