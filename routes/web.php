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


    Route::any('/wechat/wechat','wechat\WachatController@wechat');
    Route::any('/wechat/index','wechat\WachatController@index');
    Route::any('/weui/userinfo','wechat\WachatController@userinfo');
    Route::any('/weui/wechatcode','wechat\WachatController@wechatcode');

    Route::any('/weui/curlget','wechat\WachatController@curlget');
    Route::any('/weui/curlpost','wechat\WachatController@curlpost');

    //日志
    Route::any('/wechat/event','wechat\EvntController@event');


});



