<?php

include __DIR__.'/include.php';

$server = new Swoole\WebSocket\Server('127.0.0.1', 9501, SWOOLE_BASE);
$server->set(['open_http2_protocol' => true]);
// http && http2
$server->on('request', function (Swoole\Http\Request $request, Swoole\Http\Response $response) {
    $response->end('Hello ' . $request->rawcontent());
});
// websocket
$server->on('message', function (Swoole\WebSocket\Server $server, Swoole\WebSocket\Frame $frame) {
    $server->push($frame->fd, 'Hello ' . $frame->data);
});
// tcp
$tcp_server = $server->listen('127.0.0.1', 9502, SWOOLE_TCP);
$tcp_server->set($tcp_options);
$tcp_server->on('receive', function (Swoole\Server $server, int $fd, int $reactor_id, string $data) {
    $server->send($fd, tcp_pack('Hello ' . tcp_unpack($data)));
});
$server->start();