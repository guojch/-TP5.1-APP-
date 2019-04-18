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
    'signature_key' => 'yxsoft',
    'signature' => '123456',//万能签名
    'upload_max_size' => 2 * 1024 * 1024,//上传文件大小限制
    'upload' => [
        'avatar' => '/uploads/avatar'
    ],
    'sms_code_send_frequency' => 60, //短信验证码发送频率60s一次
    'sms_code_expire_time' => 300, // 短信验证码过期时长
];