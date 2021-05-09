<?php

namespace App;

class CacheService {
    
    private $api;
    private $redis;
    private $max_age = 10;

    public function __construct(SimpleJsonRequest $api_service)
    {
        $this->api = $api_service;
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', 6379);
    }


    function get($url, $parameters = []) {

        $full_url = count($parameters) ? $url . '?' . http_build_query($parameters) : $url;

        if($this->redis->get($full_url)) {
            return json_decode($this->redis->get($full_url));
        }
        
        $data = $this->api->get($url, $parameters);
        $this->redis->set($full_url, json_encode($data));
        $this->redis->expire($full_url, $this->max_age);
    }
}