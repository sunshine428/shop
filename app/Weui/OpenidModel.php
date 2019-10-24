<?php

namespace App\weui;

use Illuminate\Database\Eloquent\Model;

class OpenidModel extends Model
{
    protected $table = 'openid';// 表
    protected $primaryKey = 'oid';// 主键
    // 定义常量时间
    // const CREATED_AT = 'add_time';
    // const UPDATED_AT = 'update_time';
    //  int类型 时间
    // protected $dateFormat = 'U'; // U表示时间戳类型/
    protected $guarded = [];// 不可批量赋值的属性。 不加字段 可以通过
    // protected $fillable = [];
    // // 可批量赋值的属性。 要加字段  可以通过
    // 取消自动维护
    public $timestamps = false;
}
