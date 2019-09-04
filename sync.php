<?php

$tlds = ['fr', 'com', 'be', 'it', 'es', 'ac', 'ad', 'de', 'az', 'am', 'bf', 'bg'];

function get_content_sync(string $tld) {
    $opts = array(
        'http' => [
            'method' => "GET",
            'header' => "Accept-language: fr\r\nCookie: foo=bar\r\n"
        ]
    );
    $context = stream_context_create($opts);
    $fp = fopen("http://www.google.$tld", 'r', false, $context);
    $content = stream_get_contents($fp);
    fclose($fp);

    return $content;
}

// Sync

$s = microtime(true);
echo "\nSYNC\n=====\n";
foreach ($tlds as $tld) {
    $content = get_content_sync($tld);
    printf("%s => %s\n", $tld, strlen($content));
}
printf("\nuse %f s\n", (microtime(true) - $s));


// Execute stream based sync code, all socket operations can be dynamically converted to be asynchronous IO scheduled by coroutine at runtime !

Swoole\Runtime::enableCoroutine();
$s = microtime(true);
echo "\nASYNC\n=====\n";
foreach ($tlds as $tld) {
    go(function () use ($tld) {
        $content = get_content_sync($tld);
        printf("%s => %s\n", $tld, strlen($content));
    });
}
Swoole\Event::wait();
printf("\nuse %f s\n", (microtime(true) - $s));