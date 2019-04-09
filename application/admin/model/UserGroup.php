<?php

namespace app\admin\model;

use think\Model;

class UserGroup extends Model
{

    // 表名
    protected $name = 'user_group';
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    // 追加属性
    protected $append = [
        'status_text'
    ];

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }

    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }
////进行两个表
    public function admin()
    {
//        return $this->belongsTo("Admin", "admin_id", 'id', [], 'LEFT')->setEagerlyType(0);
        return $this->hasOne('Admin', 'id', 'admin_id', [], 'LEFT')->setEagerlyType(0);
    }


}
