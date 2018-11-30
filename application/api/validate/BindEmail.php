<?php

namespace app\api\validate;


use think\Validate;

/**
 * 绑定邮箱
 * Class BindEmail
 * @package app\api\validate
 */
class BindEmail extends Validate
{
    protected $rule = [
        'email' => 'require|/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/',
        'code' => 'require'
    ];

    protected $message = [
        'email.require' => '请输入您的邮箱账号',
        'email' => '您输入的邮箱账号格式不正确，请重新输入',
        'code.require' => '请输入短信验证码'
    ];
}