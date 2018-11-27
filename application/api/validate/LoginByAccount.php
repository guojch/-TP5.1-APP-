<?php

namespace app\common\validate;


use think\Validate;

/**
 * 帐号密码登录
 * Class LoginByAccount
 * @package app\common\validate
 */
class LoginByAccount extends Validate
{
    protected $rule = [
        'account' => 'require',
        'password' => 'require'
    ];

    protected $message = [
        'account.require' => '请输入帐号',
        'password.require' => '请输入登录密码'
    ];
}