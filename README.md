# Laravel/Lumen Notify 通知库
![PHP VERSION](https://img.shields.io/badge/php-^7.0-blue)
![MIT](https://img.shields.io/github/license/qklandy/laravel-notifys) 

因依赖包guzzlehttp/client版本限制，本要求PHP版本要求7.0.0, 如果不需要可以自行定义移除依赖包

当前支持的通知应用:
1. 支持钉钉机器人通知
2. 支持微信企业机器人通知

## Table of Contents

1. [安装](#安装)
1. [使用](#使用)
    1. [钉钉使用](#钉钉使用)
    1. [微信使用](#微信使用)

## 安装

### Composer:

```
composer require qklin/laravel-notifys
```

### 配置
#### env
```
# custom define your QKLIN_NOTIFY_CONFIG
QKLIN_NOTIFY_CONFIG=notify
```

#### {base}/config/{QKLIN_NOTIFY_CONFIG}.php
```
return [
    'default' => 'alarm_wx',
    'bizs' => [
        'alarm_dd' => [
            'driver' => 'dingding',
            'api' => 'https://oapi.dingtalk.com/robot/send?access_token={access_token}'
        ],
        'alarm_wx' => [
            'driver' => 'weixin',
            'api' => 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key={access_token}'
        ],
    ]
];
```

### register provider
```
# add provider
$app->register(Qklin\Notify\NotifyProvider::class);
```

## 使用

### 钉钉使用

#### text
```
Notify::text("测试文字，不通知所有人", [mobile], false);
Notify::text(function(){return [];}, "测试文字，不通知所有人", [mobile], false);
```

#### link
```
Notify::link("标题", "内容", "https://www.baidu.com", "https://www.baidu.com/pc2.0/images/partner-box-img01.95f15298.png");
```

#### markdown
```
$markdown = <<<'MRD'
## 测试文字不通知所有人
## 副标题
1. 11
2. 333
MRD;
Notify::markdown("markdown演示", $markdown, [mobile], false);
```

#### actionCard
```
Notify::actionCard("标题", "内容", "阅读全文", "http://www.baidu.com");
Notify::actionCard("标题", "内容", "阅读全文", "http://www.baidu.com", [
    ['actionURL'=>'http://www.baidu.com','title'=>'11'],
    ['actionURL'=>'http://www.baidu.com','title'=>'22'],
]);
```

#### feedCard
```
$lists = [
    [
        "title" => 123,
        "messageURL" => "http://www.baidu.com",
        "picURL" => "https://www.baidu.com/pc2.0/images/partner-box-img01.95f15298.png",
    ],
    [
        "title" => 123,
        "messageURL" => "http://www.baidu.com",
        "picURL" => "https://www.baidu.com/pc2.0/images/partner-box-img01.95f15298.png",
    ]
];
Notify::feedCard($lists);
```


### 微信使用

#### text
```
Notify::text("测试文字，不通知所有人", [mobile], false);
Notify::text(function(){return [];}, "测试文字，不通知所有人", [mobile], false);
```

#### markdown
```
$markdown = <<<'MRD'
## 测试文字不通知所有人
## 副标题
1. 11
2. 333
MRD;
Notify::markdown("markdown演示", $markdown, [mobile], false);
```

#### image
```
Notify::link(/data/m/pc2.0/images/partner-box-img01.95f15298.png");
```

#### news
```
$articles = [
    [
        "title"       => "测试标题1",
        "description" => "测试描述1",
        "url"         => "http://baidu.com",
        "picurl"      => "https://baidu.com/123123.jpg",
    ],
    [
        "title"       => "测试标题2",
        "description" => "测试描述2",
        "url"         => "http://baidu.com",
        "picurl"      => "https://baidu.com/123123.jpg",
    ],
];
Notify::news($articles);
```
