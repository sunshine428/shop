@extends('layout.layout')

@section('title')
    文件上传
@endsection

@section('content')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>上传资源</title>
</head>
<body>
<form action="{{url('wechat/do_upload')}}"  method="post" enctype="multipart/form-data">
    @csrf
    <select name="type" id="">
        <option value="image">图片</option>
        <option value="voice">音频</option>
        <option value="video">视频</option>
        <option value="thumb">缩略图</option>
    </select>
    <br>
    <br>
    <input type="file" name="rsource">
    <br>
    <br>
    <input type="submit" value="上传">

</form>
</body>
</html>
    @endsection