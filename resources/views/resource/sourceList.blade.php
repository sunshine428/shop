@extends('layout.layout')

@section('title')
    文件上传
@endsection

@section('content')
    <div class="container">
        <button style="background: paleturquoise;border-radius:7px">图片</button>
        <button style="background: plum;border-radius:7px">音频</button>
        <button style="background: palegreen;border-radius:7px">视频</button>
        <button style="background: mediumpurple;border-radius:7px">缩略图</button>
        <br>
        <br>
        <table border="1" cellspacing="0" style="border:1px solid deepskyblue">
            <tr style="text-align: center">
                <td>ID</td>
                <td>media_id</td>
                <td>path</td>
                <td>添加时间</td>
                <td>操作</td>
            </tr>
            @foreach($info as $v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->media_id}}</td>
                <td>{{$v->path}}</td>
                <td>{{date('Y-m-d H:i:s',$v->addtime)}}</td>
                <td><a href="">下载资源</a></td>
            </tr>
                @endforeach
        </table>
    </div>
@endsection