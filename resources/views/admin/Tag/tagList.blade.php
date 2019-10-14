
@extends('layout.layout')

@section('title')
   标签列表
@endsection

@section('content')
   <h4 align="center">标签列表</h4>
    <div style="width: 500px;height:100px;padding-left:350px "><button style="background: indianred"><a href="/shop/labelDo" style="text-decoration:none;color:black">添加标签</a></button></div>
    <table border="1">
        <tr>
            <td>标签ID</td>
            <td>标签名称</td>
            <td>操作</td>
        </tr>
        <tr>
            <td></td>
        </tr>
    </table>
@endsection