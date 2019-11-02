<?php

namespace Qklin\Notify\Parse;

interface ParseBase
{
    public function text($content, $atMobiles = [], $atMembers = [], $isAtAll = false, $injectTime = false);

    public function markdown($title, $markdown, $atMobiles = [], $atMembers = [], $isAtAll = false, $injectTime = false, $prefix = "");

    public function image($imagePath);

    public function feedCard($lists);
}