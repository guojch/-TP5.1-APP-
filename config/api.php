<?php

/**
 * Api基础配置文件
 */
return [
    'device_os' => [
        'iOS',
        'android'
    ],
    'aes_key' => 'lPwIYiE*ZO^V%1%x',
    'aes_hex_iv' => '00000000000000000000000000000000',
    'encryption_key' => 'eVPmlkRRX!dQENx6',
    'upload_max_size' => 2 * 1024 *1024,//上传文件大小限制
    'upload' => [
        'avatar' => '/uploads/avatar'
    ],
];