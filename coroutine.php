<?php

go(function () {
    // http
    $http_client = new Swoole\Coroutine\Http\Client('www.google.fr', 80);
    assert($http_client->get('/'));
    var_dump($http_client->body);
});

go(function () {
    // http2
    $http2_client = new Swoole\Coroutine\Http2\Client('www.google.fr', 443);
    $http2_client->connect();
    $http2_request = new Swoole\Http2\Request;
    $http2_request->method = 'GET';
    $http2_client->send($http2_request);
    $http2_response = $http2_client->recv();
    var_dump($http2_response->data);
});