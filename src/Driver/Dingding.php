<?php

namespace Qklin\Notify\Driver;

use Qklin\Notify\Parse\Dingding as DingParse;

class Dingding
{
    public function __construct($config)
    {
        $this->_api = $config['api'];
        $this->_parse = new DingParse();
    }

    public function text(...$args)
    {
        $requestData = $this->_parse->text(...$args);
        $response = $this->request($this->_api, $requestData, true);
        return $response;
    }

    public function link(...$args)
    {
        $requestData = $this->_parse->link(...$args);
        $response = $this->request($this->_api, $requestData, true);
        return $response;
    }

    public function markdown(...$args)
    {
        $requestData = $this->_parse->markdown(...$args);
        $response = $this->request($this->_api, $requestData, true);
        return $response;
    }

    public function actionCard(...$args)
    {
        $requestData = $this->_parse->actionCard(...$args);
        $response = $this->request($this->_api, $requestData, true);
        return $response;
    }

    public function feedCard(...$args)
    {
        $requestData = $this->_parse->feedCard(...$args);
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