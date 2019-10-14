
@extends('layout.layout')

@section('title')
   标签列表
@endsection

@section('content')
    <style>
        button{
            background:orange;width:150px;height:35px;
        }
    </style>
   <h4 align="center">标签添加</h4>

   <form action="/shop/labelSave" method="post" >
      标签名：<input type="text" placeholder="请添加标签名" name="label_name">
       <br>
       <br>
       <button type="submit">添加标签</button>
   </form>

@endsection