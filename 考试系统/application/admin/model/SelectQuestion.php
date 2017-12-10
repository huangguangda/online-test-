<?php
namespace app\admin\model;

use think\Model;

class SelectQuestion extends Model
{
    // 写入时自动完成题目类型的赋值
    protected $auto = [
        'type'
    ];

    protected function setTypeAttr($value)
    {
        return $value > 1 ? '多' : '单';
    }
    
    // 一对多关联
    public function items()
    {
        return $this->hasMany('SelectItem');
    }
}
?>