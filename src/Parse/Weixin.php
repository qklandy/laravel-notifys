<?php

namespace Qklin\Notify\Parse;

class Weixin
{
    /**
     * @param       $content
     * @param array $atMobiles
     * @param array $atMembers
     * @param bool  $isAtAll
     * @param bool  $injectTime
     * @return array
     */
    public function text($content, $atMobiles = [], $atMembers = [], $isAtAll = false, $injectTime = false)
    {
        // Notify::text("测试文字，不通知所有人", [mobile], [members], false);
        // Notify::text(function(){return [];}, "测试文字，不通知所有人", [mobile], [members], false);
        $data = [
            "msgtype" => "text",
            "text"    => [
                "content"               => ($injectTime ? date('Y-m-d H:i:s') . PHP_EOL : "") . $content,
                "mentioned_list"        => $atMembers ?: [],
                "mentioned_mobile_list" => $atMobiles ?: ($isAtAll ? ['@all'] : []),
            ],
        ];

        if (empty($atMembers)) {
            unset($data['text']['mentioned_list']);
        }

        if (empty($atMembers) && !$isAtAll) {
            unset($data['text']['mentioned_mobile_list']);
        }

        return $data;
    }

    /**
     * @param        $markdown
     * @param bool   $injectTime
     * @param string $prefix
     * @return array
     */
    public function markdown($markdown, $injectTime = false, $prefix = "")
    {
//          $markdown = <<<'MRD'
//## 测试文字不通知所有人
//## 副标题
//1. 11
//2. 333
//MRD;
//
//          Notify::markdown(function(){return [];}, $markdown);
        $data = [
            "msgtype"  => "markdown",
            "markdown" => [
                "content" => ($injectTime ? $prefix . date('Y-m-d H:i:s') . PHP_EOL : "") . $markdown
            ]
        ];

        return $data;
    }

    /**
     * @param $imagePath
     * @return array
     */
    public function image($imagePath)
    {
        $data = [
            "msgtype" => "image",
            "image"   => [
                "base64" => base64_encode(file_get_contents($imagePath)),
                "md5"    => md5_file($imagePath), //消息
            ]
        ];

        return $data;
    }

    /**
     * @param $title
     * @param $lists
     * @return array
     */
    public function news($articles)
    {
//        $articles = [
//            [
//                "title" => 123,
//                "description" => "http://www.baidu.com",
//                "url" => "http://www.baidu.com",
//                "picurl" => "https://www.baidu.com/pc2.0/images/partner-box-img01.95f15298.png",
//            ],
//            ...
//        ];
//        Notify::news(function(){return [];}, $articles);
        if (sizeof($articles) > 8) {
            array_splice($articles, 0, 8);
        }
        $data = [
            "msgtype" => "news",
            "news"    => [
                'articles' => $articles
            ]
        ];

        return $data;
    }
}