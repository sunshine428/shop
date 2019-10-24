<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware'=>['CheckLogin']],function(){
    //商品
    Route::get('/','Admin\ShopController@index');
    Route::any('/shop/index','Admin\ShopController@index');
    Route::any('/shop/save','Admin\ShopController@save');
    Route::any('/shop/info','Admin\ShopController@info');

    //删除
    Route::any('/shop/delete/{id}','Admin\ShopController@delete');
    //修改
    Route::get('/shop/edit/{id}','Admin\ShopController@edit');
    Route::post('/shop/edit/{id}','Admin\ShopController@update');


    //管理
    Route::any('/admin/index','Admin\AdminController@index');
    Route::any('/admin/save','Admin\AdminController@save');
    //删除
    Route::any('/admin/delete/{id}','Admin\AdminController@delete');
    //修改
    Route::get('/admin/edit/{id}','Admin\AdminController@edit');
    Route::post('/admin/edit/{id}','Admin\AdminController@update');

    //分类
    Route::any('/sort/index','Admin\SortController@index');
    Route::any('/sort/save','Admin\SortController@save');
    Route::any('/sort/delete','Admin\SortController@delete');
    Route::any('/sort/update','Admin\SortController@update');
     //删除
    Route::any('/sort/delete/{id}','Admin\SortController@delete');
    //修改
    Route::get('/sort/edit/{id}','Admin\SortController@edit');
    Route::post('/sort/edit/{id}','Admin\SortController@update');

    //品牌
    Route::any('/brand/index','Admin\BrandController@index');
    Route::any('/brand/save','Admin\BrandController@save');
    //删除
    Route::any('/brand/delete/{id}','Admin\BrandController@delete');
    //修改
    Route::get('/brand/edit/{id}','Admin\BrandController@edit');
    Route::post('/brand/edit/{id}','Admin\BrandController@update');
   



    // Route::get('/logout', 'admin\UserController@index')->name('logout');
    // Route::get('/send', 'admin\UserController@send');


    //注册 登录
    Route::get('/logout', 'admin\UserController@logout')->name('logout');

    Route::get('/send', 'admin\UserController@send');


});

//标签
Route::any('/shop/tag_list','Admin\TagController@Tag_list');
Route::any('/shop/add_tag','Admin\TagController@add_tag');
Route::any('/shop/do_add_tag','Admin\TagController@do_add_tag');
Route::any('/shop/update_tag','Admin\TagController@update_tag');
Route::any('/shop/do_update_tag','Admin\TagController@do_update_tag');
Route::any('/shop/del_tag','Admin\TagController@del_tag');

// 用户管理 微信
// 标签 管理
Route::any('/wechat/sign','wechat\SignController@sign');//添加表签
Route::any('/wechat/signindex','wechat\SignController@signindex');//表签列表
Route::any('/wechat/delsign','wechat\SignController@delsign');//表签删除
Route::any('/wechat/updatesign','wechat\SignController@updatesign');//表签修改
// 粉丝 管理
Route::any('/wechat/fans','wechat\FansController@fans');//粉丝列表
Route::any('/wechat/addsign','wechat\FansController@addsign');//加标签
Route::any('/wechat/tagsign','wechat\FansController@tagsign');//查看所属标签
Route::any('/wechat/tagfans','wechat\FansController@tagfans');//当前标签下的粉丝
Route::any('/wechat/delfans','wechat\FansController@delfans');//取消当前标签下的粉丝


Route::any('/wechat/push_tag_msg','wechat\MsgController@push_tag_msg');//发送消息
//模板消息
Route::get('/wechat/push_template_msg','wechat\MsgController@push_template_msg');//推送模板消息

Route::any('/weui/curlget','wechat\WachatController@curlget');
Route::any('/weui/curlpost','wechat\WachatController@curlpost');



Route::any('/aaa','wechat\CurlController@aaa');
//日志
Route::any('/wechat/event','wechat\EventController@event');
//上传资源
Route::get('/wechat/upload','wechat\ResourceController@upload');
Route::post('/wechat/do_upload','wechat\ResourceController@do_upload');
Route::get('/wechat/source_list','wechat\ResourceController@source_list');
Route::any('/wechat/resource_list','wechat\ResourceController@resource_list');

//自定义菜单
Route::any('/wechat/wechat_menu','wechat\MenuController@wechat_menu');
Route::any('/wechat/load_meun','wechat\MenuController@load_meun');


Route::any('/wechat_message_login','wechat\MessageController@wechat_message_login')->name('wechat_message_login');//微信登录
Route::group(['middleware'=>['MessageLogin']],function(){
    Route::get('/','Admin\ShopController@index');
    Route::any('/wechat/message_list','wechat\MessageController@message_list');
    Route::any('/wechat/message','wechat\MessageController@message');
});
//微信授权登录
Route::any('/userinfo','wechat\MessageController@userinfo');
Route::any('/wechatcode','wechat\MessageController@wechatcode');

// 二维码
Route::any('/wechat/qrcode','wechat\QrcodeController@qrcode');
Route::any('/wechat/add_code','wechat\QrcodeController@add_code');

// 验 签
Route::any('/wechat/sdk','wechat\QrcodeController@sdk');

// 课程
Route::any('/wechat/course','wechat\CourseController@course');

