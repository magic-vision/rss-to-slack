<?php

namespace Rts;

class WebPusher
{
    private $url;

    private $defaultParams = [];

    /**
     * WebPusher constructor.
     * @param $url
     * @param array $defaultParams
     */
    public function __construct($url, array $defaultParams)
    {
        $this->url = $url;
        $this->defaultParams = $defaultParams;
    }

    public function push(array $params)
    {

        $message = array_merge($this->defaultParams, $params);
        $data = json_encode($message);

        print_r($message);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($ch);

        var_dump($data);die;
    }
}
