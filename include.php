<?php

$tcp_options = [
    'open_length_check' => true,
    'package_length_type' => 'N',
    'package_length_offset' => 0,
    'package_body_offset' => 4
];

function tcp_pack(string $data): string
{
    return pack('N', strlen($data)) . $data;
}
function tcp_unpack(string $data): string
{
    return substr($data, 4, unpack('N', substr($data, 0, 4))[1]);
}