<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceModel extends Model
{
    //与模型关联得到表名
    protected $table='source';
    //重定义主键
    protected $primaryKey="id";
    //指示是否自动维护时间戳
    public $timestamps=false;
    //模型的连接名称
    protected $connection='mysql';
}
