<?php
namespace app\admin\validate;

use think\Validate;

class SelectValidate extends Validate
{

    protected $rule = [
        'subject' => 'require',
        'title' => 'require',
        'item1' => 'require',
        'item2' => 'require',
        'item3' => 'require',
        'item4' => 'require',
        'type' => 'gt:0'
    ];

    protected $message = [
        'subject.require' => '必须指定科目',
        'title.require' => '题目问题描述不能为空！',
        'item1.require' => '选项不参为空！',
        'item2.require' => '选项不参为空！',
        'item3.require' => '选项不参为空！',
        'item4.require' => '选项不参为空！',
        'type' => '必须提供参考答案！'
    ];
}

?>