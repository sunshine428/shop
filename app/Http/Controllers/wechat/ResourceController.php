<?php

namespace App\Http\Controllers\wechat;

use App\Http\Controllers\weui\WeuiController;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ResourceModel;

class ResourceController extends Controller
{
    public function upload(){
        return view('resource.upload');
    }
    /** 临时素材*/
   /* public function do_upload(Request $request){
        $req=$request->all();
        if(!$request->hasFile('rsource')){
          dd('没有文件');
        }
        $file_obj=$request->file('rsource');
        $ext= $file_obj->getClientOriginalExtension();
        $file_name=time().rand(1000,9999).'.'.$ext;
        $path=$request->file('rsource')->storeAs('wechat/'.$req['type'],$file_name);
       // echo storage_path('app/public/'.$path);
//        dd($path);
        $wechat_user=CurlController::get_access_token();
        $url='https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$wechat_user.'&type='.$req['type'];
        $re=CurlController::wechat_curl_file($url,storage_path('app/public/'.$path));

        $result=json_decode($re,1);
        dd($result);
    }*/
    /** 永久素材*/
    public function do_upload(Request $request){
        $req=$request->all();
        $type_arr=['image'=>1,'voice'=>2,'video'=>3,'thumb'=>4];
        if(!$request->hasFile('rsource')){
          dd('没有文件');
        }
        $file_obj=$request->file('rsource');
        $ext= $file_obj->getClientOriginalExtension();
        $file_name=time().rand(1000,9999).'.'.$ext;
        $path=$request->file('rsource')->storeAs('wechat/'.$req['type'],$file_name);
       // echo storage_path('app/public/'.$path);
//        dd($path);
        $wechat_user=CurlController::get_access_token();
        $url='https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$wechat_user.'&type='.$req['type'];
        $data=[
            'media'=>new \CURLFile(storage_path('app/public/'.$path))
        ];
        if($req['type']=='video'){
            $data['description']=json_encode(['title'=>'标题','introduction'=>'描述'],JSON_UNESCAPED_UNICODE);
        };

        $re=CurlController::wechat_curl_file($url,$data);
        $result=json_decode($re,1);

        if(!isset($result['errcode'])){
           $data= ResourceModel::insert([
                'media_id'=>$result['media_id'],
                'type'=>$type_arr[$req['type']],
                'path'=>'/storage/'.$path,
                'addtime'=>time(),
            ]);
        }
        return redirect('/wechat/resource_list');
    }
    /** 列表 */
    public function resource_list(Request $request){
    $req=$request->all();
    !isset($req['type'])? $type=1 : $type = $req['type'];
    $info=ResourceModel::where(['type'=>$type])->paginate(10);
    return view('resource.sourceList',['info'=>$info]);
}
    /** 素材列表 */
    public function source_list(){
        $get_access_token=CurlController::get_access_token();
        $url='https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token='.$get_access_token;
        $data=[
          'type'=>'voice',
            'offset'=>'0',
            'count'=>20
        ];
        $re=CurlController::curlpost($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result=json_decode($re,1);
        dd($result);
    }

}
