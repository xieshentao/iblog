<?php
// 事件定义文件
return [
    'bind'    =>    [
        'Auth' => 'app\event\Auth',
        // 更多事件绑定
    ],

    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe' => [
    ],
];
