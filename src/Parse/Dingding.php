<?php
// https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.karFPe&treeId=257&articleId=105735&docType=1#s2

namespace Qklin\Notify\Parse;

class Dingding implements ParseBase
{
    /**
     * @param       $content
     * @param array $atMobiles
     * @param bool  $isAtAll
     * @param bool  $injectTime
     * @return array
     */
    public function text($content, $atMobiles = [], $atMembers = [], $isAtAll = false, $injectTime = false)
    {
        // Notify::text("测试文字，不通知所有人", [mobile], false);
        // Notify::text(function(){return [];}, "测试文字，不通知所有人", [mobile], false);
        $data = [
            "msgtype" => "text",
            "text"    => [
                "content" => ($injectTime ? date('Y-m-d H:i:s') . PHP_EOL : "") . $content
            ],
            "at"      => [
                "atMobiles" => $atMobiles,
                "isAtAll"   => $isAtAll
            ]
        ];

        if (empty($atMobiles)) {
            unset($data['at']['atMobiles']);
        }

        return $data;
    }

    /**
     * @param $title
     * @param $content
     * @param $url
     * @param $picUrl
     * @return array
     */
    public function link($title, $content, $url, $picUrl)
    {
//        Notify::link(function(){return [];}, "标题", "内容", "https://www.baidu.com", "https://www.baidu.com/pc2.0/images/partner-box-img01.95f15298.png");
        $data = [
            "msgtype" => "link",
            "link"    => [
                "title"      => $title,
                "text"       => $content,
                "messageUrl" => $url,
                "picUrl"     => $picUrl,
            ]
        ];

        return $data;
    }

    /**
     * @param       $title
     * @param       $content
     * @param array $atMobiles
     * @param bool  $isAtAll
     * @param bool  $injectTime
     * @return array
     */
    public function markdown($title, $content, $atMobiles = [], $isAtAll = false, $injectTime = false, $prefix = "")
    {
//          $markdown = <<<'MRD'
//## 测试文字不通知所有人
//## 副标题
//1. 11
//2. 333
//MRD;
//
//          Notify::markdown(function(){return [];}, "markdown演示", $markdown, [mobile], false);
        $data = [
            "msgtype"  => "markdown",
            "markdown" => [
                "title" => $title,
                "text"  => ($injectTime ? $prefix . date('Y-m-d H:i:s') . PHP_EOL : "") . $content
            ],
            "at"       => [
                "atMobiles" => $atMobiles,
                "isAtAll"   => $isAtAll
            ]
        ];

        if (empty($atMobiles)) {
            unset($data['at']['atMobiles']);
        }

        return $data;
    }

    /**
     * @param       $title
     * @param       $text
     * @param       $singleTitle
     * @param       $singleURL
     * @param array $btns [['actionURL'=>'','title'=>'']]
     * @param int   $btnOrientation
     * @param int   $hideAvatar
     * @return array
     */
    public function actionCard($title, $text, $singleTitle, $singleURL, $btns = [], $btnOrientation = 0, $hideAvatar = 0)
    {
//        Notify::actionCard(function(){return [];}, "标题", "内容", "阅读全文", "http://www.baidu.com");
//        Notify::actionCard(function(){return [];}, "标题", "内容", "阅读全文", "http://www.baidu.com", [
//            ['actionURL'=>'http://www.baidu.com','title'=>'11'],
//            ['actionURL'=>'http://www.baidu.com','title'=>'22'],
//        ]);
        $data = [
            "msgtype"    => "actionCard",
            "actionCard" => [
                "title"          => $title, //首屏会话透出的展示内容
                "text"           => $text, //消息
                "singleTitle"    => $singleTitle, //单个按钮的方案。(设置此项和singleURL后btns无效。)
                "singleURL"      => $singleURL, //点击singleTitle按钮触发的URL
                "btnOrientation" => $btnOrientation, //0-按钮竖直排列，1-按钮横向排列
                "hideAvatar"     => $hideAvatar, //0-正常发消息者头像,1-隐藏发消息者头像
            ]
        ];

        if (!empty($btns)) {
            $data['actionCard']['btns'] = $btns;
            unset($data['actionCard']['singleTitle'], $data['actionCard']['singleURL']);
        }

        return $data;
    }

    /**
     * @param $imagePath
     */
    public function image($imagePath)
    {
        // nothing
    }

    /**
     * @param $title
     * @param $lists
     * @return array
     */
    public function feedCard($lists)
    {
//        $lists = [
//            [
//                "title" => 123,
//                "messageURL" => "http://www.baidu.com",
//                "picURL" => "https://www.baidu.com/pc2.0/images/partner-box-img01.95f15298.png",
//            ],
//            [
//                "title" => 123,
//                "messageURL" => "http://www.baidu.com",
//                "picURL" => "https://www.baidu.com/pc2.0/images/partner-box-img01.95f15298.png",
//            ]
//        ];
//        Notify::feedCard(function(){return [];}, $lists);
        $data = [
            "msgtype"  => "feedCard",
            "feedCard" => [
                'links' => $lists
            ]
        ];

        return $data;
    }
}