<?php

namespace app\api\validate;


use think\Validate;

/**
 * 第三方登录，绑定新账号
 * Class BindNewAccount
 * @package app\api\validate
 */
class BindNewAccount extends Validate
{
    protected $rule = [
        'bind_number' => 'require|/^1[3456789]\d{9}$/',
        'code' => 'require',
        'bind_oauth_id' => 'require',
        'password' => 'require|min:6|max:12|/^[0-9a-zA-Z_]{1,}$/',
        'password_again' => 'require'
    ];

    protected $message = [
        'bind_number.require' => '请输入您的手机号码',
        'bind_number' => '您输入的手机号码格式不正确，请重新输入',
        'code.require' => '请输入短信验证码',
        'password.require' => '请输入密码',
        'password.min' => '密码长度为6-12字符',
        'password.max' => '密码长度为6-12字符',
        'password' => '密码不可包含非法字符',
        'password_again.require' => '请输入重复密码'
    ];
}