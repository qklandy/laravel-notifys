<?php

if (!function_exists('qklin_json_encode')) {
    /**
     * json编码
     * @param $data
     * @return false|string
     */
    function qklin_json_encode($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE + JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('qklin_http_request')) {
    /**
     * json编码
     * @param $data
     * @return false|string
     */
    function qklin_http_request($method, $api, $playload, $type = 'form_params', $header = [], $toArray = true)
    {
        $client = new \GuzzleHttp\Client();
        $options = [];

        $method = strtoupper($method);
        if ($method == 'GET') {
            $options['query'] = $playload;
        } else if ($method == 'POST' && $type == 'form_params') {
            $options['form_params'] = $playload;
        } else if ($method == 'POST' && $type == 'json') {
            $options['json'] = $playload;
        }

        if (!empty($header)) {
            $options['header'] = $header;
        }

        $response = $client->request($method, $api, $options);
        $responseCode = $response->getStatusCode();
        $responseContent = $response->getBody()->getContents();

        if (app()->bound('Psr\Log\LoggerInterface')) {
            app('Psr\Log\LoggerInterface')->info('request log', [
                'url'      => $api,
                'httpcode' => $responseCode,
                'response' => $responseContent,
            ]);
        }

        $rst = [
            'httpcode' => $responseCode,
            'response' => $toArray ? json_decode($responseContent, true) : $responseContent
        ];

        return $rst;
    }
}