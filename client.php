<?php

include __DIR__.'/include.php';

go(function () {
    // http
    $http_client = new Swoole\Coroutine\Http\Client('127.0.0.1', 9501);
    assert($http_client->post('/', 'Swoole Http'));
    var_dump($http_client->body);
    // websocket
    $http_client->upgrade('/');
    $http_client->push('Swoole Websocket');
    var_dump($http_client->recv()->data);
});
go(function () {
    // http2
    $http2_client = new Swoole\Coroutine\Http2\Client('localhost', 9501);
    $http2_client->connect();
    $http2_request = new Swoole\Http2\Request;
    $http2_request->method = 'POST';
    $http2_request->data = 'Swoole Http2';
    $http2_client->send($http2_request);
    $http2_response = $http2_client->recv();
    var_dump($http2_response->data);
});
go(function () use ($tcp_options) {
    // tcp
    $tcp_client = new Swoole\Coroutine\Client(SWOOLE_TCP);
    $tcp_client->set($tcp_options);
    $tcp_client->connect('127.0.0.1', 9502);
    $tcp_client->send(tcp_pack('Swoole Tcp'));
    var_dump(tcp_unpack($tcp_client->recv()));
});