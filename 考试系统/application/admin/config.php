<?php
return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------
    'template' => [
        // 模板引擎类型 支持 php think 支持扩展
        'view_suffix' => 'html'
    ],
     'view_replace_str' => [
        '__PUBLIC__' => WEBNAME . '/public/',
        '__ROOT__' => WEBNAME . '/',
        '__STUDENT__' => WEBNAME . '/public/static/student'
    ],
    // 控制器类后缀
    'controller_suffix'      => 'true',
];