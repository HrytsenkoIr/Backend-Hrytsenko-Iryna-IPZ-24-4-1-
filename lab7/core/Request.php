<?php

// хбирання даних запиту для TrafficLogger, який запише в бд

class Request
{
    public $ip;
    public $url;
    public $time;

    public function __construct()
    {
        // IP користувача
        $this->ip = isset($_SERVER['REMOTE_ADDR'])
            ? $_SERVER['REMOTE_ADDR']
            : 'unknown';

        // Повний URL-шлях
        $this->url = isset($_SERVER['REQUEST_URI'])
            ? $_SERVER['REQUEST_URI']
            : '/';

        // Час запиту
        $this->time = time();
    }
}
