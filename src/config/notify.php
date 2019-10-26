<?php

return [
    'default' => 'alarm',
    'bizs' => [
        'alarm' => [
            'driver' => 'dingding',
            'api' => 'https://oapi.dingtalk.com/robot/send?access_token={access_token}'
        ],
        'alarm_wx' => [
            'driver' => 'weixin',
            'api' => 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key={access_token}'
        ],
    ]
];