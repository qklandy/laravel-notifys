<?php

namespace Qklin\Notify\Driver;

use Qklin\Notify\Parse\Weixin as WeixinParse;

class Weixin
{
    /**
     * @var WeixinParse
     */
    private $_parse;

    public function __construct($config)
    {
        $this->_api = $config['api'];
        $this->_parse = new WeixinParse();
    }

    public function text(...$args)
    {
        $requestData = $this->_parse->text(...$args);
        $response = $this->request($this->_api, $requestData, true);
        return $response;
    }

    public function markdown(...$args)
    {
        $requestData = $this->_parse->markdown(...$args);
        $response = $this->request($this->_api, $requestData, true);
        return $response;
    }

    public function image(...$args)
    {
        $requestData = $this->_parse->image(...$args);
        $response = $this->request($this->_api, $requestData, true);
        return $response;
    }

    public function news(...$args)
    {
        $requestData = $this->_parse->news(...$args);
        $response = $this->request($this->_api, $requestData, true);
        return $response;
    }

    /**
     * 请求
     * @param      $api
     * @param      $playload
     * @param bool $toArray
     * @return bool
     */
    public function request($api, $playload, $toArray = false)
    {
        $result = qklin_http_request('POST', $api, $playload, 'json', [], $toArray);
        if ($result['httpcode'] != 200) {
            return false;
        }

        return $result['response'];
    }
}