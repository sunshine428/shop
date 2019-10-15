@extends('layout.layout')

@section('title')
    粉丝列表
@endsection


@section('content')
    <div>
        <h3 style="text-align: center ;"><font color='blue' style="color:orangered">粉丝列表</font></h3>
    </div>
    <br>
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
                <td align="center"><a href="/wechat/tagsign?openid={{ $v['openid'] }}">查看所属标签</a></td>
            </tr>
        @endforeach
        </tbody>
        @if(isset($id))
            <tr>
                <td colspan="8" align="center">
                    <input type="submit"  class="btn btn-primary sign" value="立即提交">
                    <input type="button"  class="btn btn-danger" value="取消标签" id="but">
                </td>
            </tr>


        @endif
    </table>
    </form>
    {{-- 取消标签--}}
    <script>
        $(function(){
            $(document).on('click','#but',function(){
                var _this = $(this);
                var odj = $('[name="openid_list[]"]:checked');
                var id = $('[name="id"]').val();
                // alert(id);return;
                var arr = new Array();// 定义数组
                // 循环 odj
                $.each(odj,function(){
                    var id = $(this).val();
                    arr.push(id);// 把id 放到数组中
                })
                $.ajax({
                    url:"/wechat/delfans",//请求地址
                    type:'get',//请求的类型
                    dataType:'json',//返回的类型
                    data:{openid:arr,id:id},//要传输的数据
                    success:function(res){ //成功之后回调的方法
                       
                    }
                })
            })
        })
    </script>
@endsection

